@extends('layouts.admin')

@section('content')
<div class="main-content">

    <div class="modal-overlay">
        <div class="modal-upload">
          <div class="upload-header">Bulk Upload</div>
          <p class="upload-subtext">Pastikan file .xlsx atau .csv sudah sesuai dengan format upload</p>
          <!-- Step 1: Upload Form -->
          <div class="upload-area" id="uploadStep">
            <!-- <p id="file-name" style="margin-top: 10px; font-size: 14px; color: #333;"></p> -->
            <div class="upload-box">
                <div id="upload-instruction">
                    <label for="data-peminjaman" class="upload-btn">
                        <i class="fas fa-cloud-arrow-up"></i>
                    </label>
                    <p><strong>Drag & drop files</strong> or <span class="browse">Browse</span></p>
                    <small>Supported formats: .xlsx, .csv</small>
                </div>

                <p id="file-name" style="margin-top: 10px; font-size: 16px; font-weight:800; color: #5f2eea;"></p>
            </div>
            <div class="template-download">
              Template bulk upload download <a href="{{ route('admin.verifikasi.peminjaman.template.download') }}">Here</a>
            </div>
            <div class="button-row">
                <form action="{{ route('admin.verifikasi.peminjaman.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="data-peminjaman" name="file" accept=".xlsx,.csv" class="file-input" hidden>

                    <div class="button-row">
                        <button type="button" class="btn cancel" onclick="window.location='{{ route('admin.verifikasi.peminjaman.index') }}'">
                            Batal
                        </button>
                        <button type="submit" class="btn upload">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        
          <!-- Step 2: Upload Progress -->
          <div class="progress-area" id="progressStep" style="display: none;">
            <div class="progress-circle">
              <svg class="circle" viewBox="0 0 36 36">
                <path class="bg" d="M18 2.0845
                  a 15.9155 15.9155 0 0 1 0 31.831
                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="progress" id="progressPath"
                  stroke-dasharray="40, 100"
                  d="M18 2.0845
                  a 15.9155 15.9155 0 0 1 0 31.831
                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                <text x="18" y="20.35" class="percentage">40%</text>
              </svg>
            </div>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 40%"></div>
            </div>
            <div class="progress-label">Upload on progress</div>
            <div class="button-row">
              <button class="btn cancel">Cancel</button>
            </div>
          </div>
        </div>
    
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
    .modal-upload {
   background: white;
    border-radius: 12px;
    padding: 24px;
    width: 90%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.upload-header {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 8px;
}



.upload-btn{
    color: #5f2eea;
    font-weight: bold;
    text-decoration: underline;
    cursor: pointer;
}

.upload-subtext {
  font-size: 14px;
  color: #555;
  margin-bottom: 24px;
}

.upload-box {
  border: 2px dashed #a0a0f0;
  border-radius: 12px;
  padding: 40px 20px;
  text-align: center;
  color: #666;
  background-color: #f9f9ff;
  margin-bottom: 16px;
}



.upload-icon {
  font-size: 40px;
  margin-bottom: 12px;
}

.browse {
  color: #5f2eea;
  text-decoration: underline;
  cursor: pointer;
}

.template-download {
  text-align: center;
  margin-bottom: 24px;
  font-size: 14px;
}

.template-download a {
  color: #5f2eea;
  text-decoration: underline;
}

.button-row {
  display: flex;
  justify-content: space-between;
  gap: 8px;
}

.btn {
  flex: 1;
  padding: 10px 21vh;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  cursor: pointer;
}

.btn.cancel {
  background: #fff;
  border: 1px solid #ccc;
  color: #555;
  text-decoration: none;
  text-align: center;
}

.btn.upload {
  background: #5f2eea;
  color: white;
}

/* Progress Step */
.progress-area {
  text-align: center;
}

.progress-circle {
  width: 100px;
  height: 100px;
  margin: 0 auto 16px;
}

.circle {
  width: 100%;
  height: 100%;
  fill: none;
}

.bg {
  stroke: #eee;
  stroke-width: 3.8;
}

.progress {
  stroke: #5f2eea;
  stroke-width: 3.8;
  stroke-linecap: round;
  transition: stroke-dasharray 0.3s ease;
}

.percentage {
  fill: #333;
  font-size: 0.5em;
  text-anchor: middle;
}

/* Progress Bar */
.progress-bar {
  background: #f0eeff;
  height: 10px;
  border-radius: 8px;
  overflow: hidden;
  margin: 12px 0;
}

.progress-fill {
  background: #5f2eea;
  height: 100%;
  width: 0%;
  transition: width 0.5s ease;
}

.progress-label {
  font-size: 14px;
  color: #666;
  margin-bottom: 16px;
}

</style>

<script>
    document.querySelector('.upload-box').addEventListener('click', () => {
    document.querySelector('#data-peminjaman').click();
});


document.getElementById('data-peminjaman').addEventListener('change', function(e) {
    const fileInput = e.target;
    const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : '';
    const fileNameDisplay = document.getElementById('file-name');
    const uploadInstruction = document.getElementById('upload-instruction');

    if (fileName) {
        // Hilangkan upload instruction
        uploadInstruction.style.display = 'none';
        // Tampilkan nama file
        fileNameDisplay.textContent = 'File selected: ' + fileName;
    } else {
        uploadInstruction.style.display = 'block';
        fileNameDisplay.textContent = '';
    }
});

</script>

@endsection
