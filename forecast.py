import mysql.connector
import pandas as pd
import numpy as np
import pmdarima as pm
from datetime import datetime, timedelta
import calendar

def run_forecast(forecast_period='year'):
    """
    Run forecast with specified time period
    
    Parameters:
    - forecast_period: String, options are 'quarter' (3 months), 'half' (6 months), 'year' (12 months)
    """
    # 1. Setting koneksi database
    db = mysql.connector.connect(
        host="localhost",
        port=3307,
        user="root",  # Ganti username jika perlu
        # password="password",  # Uncomment dan ganti jika menggunakan password
        database="skripsi"
    )
    cursor = db.cursor()
    
    # Periksa dan buat tabel jika belum ada
    create_tables(cursor, db)
    
    # 2. Setting parameter berdasarkan periode forecast yang diminta
    freq = 'D'  # Pilihan: 'D' = harian, 'W' = mingguan, 'M' = bulanan
    
    # Set forecast horizon berdasarkan periode yang diminta
    if forecast_period == 'quarter':
        forecast_horizon = 90  # 3 bulan ~= 90 hari
        period_name = "3 bulan"
    elif forecast_period == 'half':
        forecast_horizon = 180  # 6 bulan ~= 180 hari
        period_name = "6 bulan"
    else:  # default: year
        forecast_horizon = 365  # 1 tahun
        period_name = "1 tahun"
    
    metode_forecast = "ARIMA"  # Nama metode forecast yang digunakan
    
    # 3. Ambil data dari tabel peminjaman_ruangan dan agregasi berdasarkan tanggal
    print(f"Mengambil data untuk forecast periode {period_name}...")
    data = get_time_series_data(cursor, db)
    
    # 4. Preprocessing
    print("Melakukan preprocessing data...")
    data_complete = preprocess_data(data, freq)
    
    # 5. Modeling ARIMA dan Forecasting
    print(f"Membuat model ARIMA dan forecasting untuk {period_name} ke depan...")
    model, forecast_df = build_arima_model_and_forecast(data_complete, freq, forecast_horizon, metode_forecast)
    
    # 6. Simpan hasil forecast ke tabel forecasting_peminjaman
    print("Menyimpan hasil forecast ke tabel...")
    save_forecast_to_database(cursor, db, forecast_df, forecast_period)
    
    # 7. Tutup koneksi
    print("\nMenutup koneksi database...")
    cursor.close()
    db.close()
    print(f"Forecast untuk {period_name} selesai.")
    
    return True

def create_tables(cursor, db):
    """Buat tabel yang diperlukan jika belum ada"""
    # Periksa tabel forecasting_peminjaman
    if not check_table_exists(cursor, 'forecasting_peminjaman'):
        print("Tabel forecasting_peminjaman tidak ditemukan. Membuat tabel...")
        create_forecasting_table(cursor, db)
    else:
        print("Tabel forecasting_peminjaman sudah ada dalam database.")
    
    # Buat tabel konfigurasi forecast jika belum ada
    if not check_table_exists(cursor, 'forecast_config'):
        print("Tabel forecast_config tidak ditemukan. Membuat tabel...")
        create_forecast_config_table(cursor, db)
    else:
        print("Tabel forecast_config sudah ada dalam database.")

def check_table_exists(cursor, table_name):
    """Periksa apakah tabel sudah ada"""
    cursor.execute(f"SHOW TABLES LIKE '{table_name}'")
    return cursor.fetchone() is not None

def create_forecasting_table(cursor, db):
    """Buat tabel forecasting_peminjaman jika belum ada"""
    create_table_query = """
    CREATE TABLE IF NOT EXISTS forecasting_peminjaman (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tanggal_forecasting DATE NOT NULL,
        jumlah_peminjaman INT,
        bulan VARCHAR(20),
        tahun INT,
        nilai_forecast FLOAT,
        error_rate FLOAT,
        metode_forecast VARCHAR(50),
        forecast_period VARCHAR(10),
        catatan TEXT,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        INDEX (forecast_period)
    )
    """
    cursor.execute(create_table_query)
    db.commit()
    print(f"Tabel forecasting_peminjaman berhasil dibuat.")

def create_forecast_config_table(cursor, db):
    """Buat tabel konfigurasi forecast"""
    create_table_query = """
    CREATE TABLE IF NOT EXISTS forecast_config (
        id INT AUTO_INCREMENT PRIMARY KEY,
        parameter_name VARCHAR(50) NOT NULL,
        parameter_value TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
    """
    cursor.execute(create_table_query)
    
    # Insert default config values
    default_configs = [
        ('last_forecast_date', datetime.now().strftime('%Y-%m-%d')),
        ('model_parameters', '{}'),
        ('active_forecast_periods', 'quarter,half,year')
    ]
    
    insert_query = """
    INSERT INTO forecast_config (parameter_name, parameter_value)
    VALUES (%s, %s)
    """
    cursor.executemany(insert_query, default_configs)
    db.commit()
    print(f"Tabel forecast_config berhasil dibuat dengan konfigurasi default.")

def get_time_series_data(cursor, db):
    """Ambil data time series dari database"""
    try:
        # Periksa apakah tabel peminjaman_ruangan ada
        if not check_table_exists(cursor, 'peminjaman_ruangan'):
            print("PERINGATAN: Tabel peminjaman_ruangan tidak ditemukan!")
            return create_dummy_data()
        else:
            # Query data peminjaman
            query = """
                SELECT 
                    tanggal_peminjaman as tanggal, 
                    COUNT(*) as jumlah_peminjaman 
                FROM 
                    peminjaman_ruangan  
                GROUP BY 
                    tanggal_peminjaman 
                ORDER BY 
                    tanggal_peminjaman ASC
            """
            data = pd.read_sql(query, con=db)
            print(f"Berhasil mengambil {len(data)} baris data peminjaman.")
            
            # Jika tidak ada data, buat dummy data untuk testing
            if data.empty:
                print("Data peminjaman kosong, membuat dummy data untuk testing...")
                return create_dummy_data()
                
            return data
    except Exception as e:
        print(f"Error saat mengambil data: {str(e)}")
        return create_dummy_data()

def create_dummy_data():
    """Buat dummy data untuk testing"""
    print("Membuat dummy data untuk testing...")
    dummy_start_date = datetime.now() - timedelta(days=365)  # 1 tahun kebelakang
    dates = [dummy_start_date + timedelta(days=x) for x in range(365)]
    
    # Buat pola seasonality mingguan
    weekday_effects = [3, 4, 5, 3, 2, 1, 1]  # Lebih banyak peminjaman di hari kerja
    monthly_effects = [1.0, 0.9, 1.1, 1.2, 1.3, 0.8, 0.7, 0.9, 1.4, 1.2, 1.1, 1.5]  # Efek bulanan
    
    counts = []
    for date in dates:
        # Base count
        base = 2
        # Weekday effect
        weekday_effect = weekday_effects[date.weekday()]
        # Monthly effect
        month_effect = monthly_effects[date.month-1]
        # Random noise
        noise = np.random.normal(0, 1)
        
        # Combine all effects
        count = max(0, int(base * weekday_effect * month_effect + noise))
        counts.append(count)
    
    data = pd.DataFrame({
        'tanggal': dates,
        'jumlah_peminjaman': counts
    })
    print(f"Dummy data dibuat dengan {len(data)} sampel.")
    return data

def preprocess_data(data, freq):
    """Preprocess data time series"""
    # Konversi ke datetime dan set sebagai index
    data['tanggal'] = pd.to_datetime(data['tanggal'])
    min_date = data['tanggal'].min()
    max_date = data['tanggal'].max()
    
    # Buat rentang tanggal lengkap untuk memastikan tidak ada tanggal yang hilang
    full_date_range = pd.date_range(start=min_date, end=max_date, freq=freq)
    data_complete = pd.DataFrame(index=full_date_range)
    data_complete.index.name = 'tanggal'
    
    # Join dengan data aktual
    data_complete = data_complete.join(data.set_index('tanggal'))
    
    # Isi nilai NaN dengan 0 (hari tanpa peminjaman)
    data_complete['jumlah_peminjaman'] = data_complete['jumlah_peminjaman'].fillna(0)
    
    print(f"Data diproses: {len(data_complete)} baris dari {min_date.strftime('%Y-%m-%d')} hingga {max_date.strftime('%Y-%m-%d')}")
    return data_complete

def build_arima_model_and_forecast(data_complete, freq, forecast_horizon, metode_forecast):
    """Buat model ARIMA dan lakukan forecast"""
    try:
        # Set parameter seasonal berdasarkan frekuensi
        if freq == 'M':  # Bulanan
            seasonal = True
            m = 12
        elif freq == 'W':  # Mingguan
            seasonal = True
            m = 52
        else:  # Harian
            seasonal = True
            m = 7
        
        # Buat model ARIMA
        model = pm.auto_arima(
            data_complete['jumlah_peminjaman'],
            seasonal=seasonal,
            m=m,
            stepwise=True,
            suppress_warnings=True,
            error_action='ignore',  # Ignore order errors
            trace=False  # Jangan tampilkan proses fitting model
        )
        
        # Simpan informasi model
        model_info = str(model.summary())
        print("Model ARIMA yang dipilih:")
        print(model_info)
        
        # Lakukan forecasting
        forecast, conf_int = model.predict(n_periods=forecast_horizon, return_conf_int=True)
        
        # Buat index tanggal untuk hasil forecast
        last_date = data_complete.index[-1]
        if freq == 'D':
            future_dates = [last_date + timedelta(days=i) for i in range(1, forecast_horizon+1)]
        elif freq == 'W':
            future_dates = [last_date + timedelta(weeks=i) for i in range(1, forecast_horizon+1)]
        elif freq == 'M':
            future_dates = pd.date_range(start=last_date + pd.DateOffset(months=1), periods=forecast_horizon, freq='M')
        
        # Simpan hasil forecast ke DataFrame
        forecast_df = pd.DataFrame({
            'tanggal_forecasting': future_dates,
            'jumlah_peminjaman': np.round(forecast).astype(int),  # Convert to integer values
            'lower_confidence': np.round(conf_int[:, 0]).astype(int),
            'upper_confidence': np.round(conf_int[:, 1]).astype(int),
            'nilai_forecast': forecast,  # Save original float values
            'error_rate': np.abs(conf_int[:, 1] - conf_int[:, 0]) / 2  # Estimate error as half the confidence interval width
        })
        
        # Tambahkan kolom bulan dan tahun
        forecast_df['bulan'] = forecast_df['tanggal_forecasting'].apply(lambda x: calendar.month_name[x.month])
        forecast_df['tahun'] = forecast_df['tanggal_forecasting'].apply(lambda x: x.year)
        forecast_df['metode_forecast'] = metode_forecast
        forecast_df['catatan'] = f"Forecast dibuat pada {datetime.now().strftime('%Y-%m-%d %H:%M:%S')} menggunakan {model}"
        
        # Tampilkan beberapa data hasil forecast
        print("\nContoh hasil forecast (5 baris pertama):")
        for i, (date, value) in enumerate(zip(forecast_df['tanggal_forecasting'][:5], forecast_df['jumlah_peminjaman'][:5])):
            print(f"{date.strftime('%Y-%m-%d')}: {value} peminjaman")
            
        return model, forecast_df
        
    except Exception as e:
        print(f"Error dalam pemodelan: {str(e)}")
        # Return dummy model and data jika terjadi error
        return None, pd.DataFrame()

def save_forecast_to_database(cursor, db, forecast_df, forecast_period):
    """Simpan hasil forecast ke database"""
    try:
        if forecast_df.empty:
            print("Tidak ada data forecast untuk disimpan.")
            return False
            
        # Persiapkan data untuk insert
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        batch_data = []
        
        # Delete previous forecast data for this period
        delete_query = f"DELETE FROM forecasting_peminjaman WHERE forecast_period = '{forecast_period}'"
        cursor.execute(delete_query)
        
        # Insert query
        insert_query = """
        INSERT INTO forecasting_peminjaman 
        (tanggal_forecasting, jumlah_peminjaman, bulan, tahun, nilai_forecast, 
         error_rate, metode_forecast, forecast_period, catatan, created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        
        for _, row in forecast_df.iterrows():
            batch_data.append((
                row['tanggal_forecasting'].date(),
                int(row['jumlah_peminjaman']),
                row['bulan'],
                int(row['tahun']),
                float(row['nilai_forecast']),
                float(row['error_rate']),
                row['metode_forecast'],
                forecast_period,
                row['catatan'],
                now,
                now
            ))
        
        # Eksekusi batch insert
        cursor.executemany(insert_query, batch_data)
        
        # Update konfigurasi forecast terakhir
        update_config_query = """
        UPDATE forecast_config 
        SET parameter_value = %s, updated_at = %s
        WHERE parameter_name = 'last_forecast_date'
        """
        cursor.execute(update_config_query, (now[:10], now))
        
        # Commit perubahan
        db.commit()
        print(f"Sukses simpan {len(batch_data)} hasil forecast untuk periode {forecast_period} ke tabel 'forecasting_peminjaman'!")
        return True
        
    except Exception as e:
        print(f"Error saat menyimpan hasil forecast: {str(e)}")
        print("Melakukan rollback...")
        db.rollback()
        return False

# Main program untuk menjalankan forecast semua periode
if __name__ == "__main__":
    print("=== SISTEM FORECASTING PEMINJAMAN RUANGAN ===")
    print("Memulai proses forecasting untuk semua periode...")
    
    # Run forecast untuk semua periode yang dibutuhkan
    run_forecast('quarter')  # 3 bulan
    run_forecast('half')     # 6 bulan
    run_forecast('year')     # 1 tahun
    
    print("\nSeluruh proses forecasting selesai!")