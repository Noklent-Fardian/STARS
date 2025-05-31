@extends('layouts.template')
@section('title', 'Data Bobot | STARS')
@section('page-title', 'Data Bobot')
@section('breadcrumb') @endsection

@push('styles')
<!-- Bootstrap CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<!-- SweetAlert2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css" rel="stylesheet">

<style>
    .card-modern {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .card-body-modern {
        background: white;
        color: #333;
        padding: 2rem;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem 2rem;
        margin: -2rem -2rem 2rem -2rem;
        color: white;
        border-radius: 15px 15px 0 0;
    }
    
    .form-header h3 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-header .subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .table-modern {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .table-modern tbody tr {
        border: none;
        transition: all 0.3s ease;
    }
    
    .table-modern tbody tr:hover {
        background-color: #f8f9ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .table-modern tbody td {
        border: none;
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }
    
    .kriteria-label {
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .kriteria-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
        font-weight: bold;
    }
    
    .bobot-input-group {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-control-modern {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
        outline: none;
    }
    
    .bobot-percentage {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        min-width: 50px;
    }
    
    .btn-save-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-save-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-save-modern:active {
        transform: translateY(0);
    }
    
    .btn-save-modern:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .btn-save-modern:disabled:hover {
        transform: none;
        box-shadow: none;
    }
    
    .alert-modern {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .alert-success-modern {
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        color: white;
    }
    
    .alert-danger-modern {
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        color: white;
    }
    
    .total-info {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-top: 1rem;
        font-weight: 600;
        color: #8b4513;
        transition: all 0.3s ease;
    }
    
    .total-info.error {
        background: linear-gradient(135deg, #ff6b6b 0%, #ffa8a8 100%);
        color: white;
        animation: shake 0.5s ease-in-out;
    }
    
    .total-info.success {
        background: linear-gradient(135deg, #51cf66 0%, #8ce99a 100%);
        color: white;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff40;
        border-top: 2px solid #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Notification Area -->
            <div id="notifArea"></div>
            
            <div class="card card-modern fade-in">
                <div class="card-body card-body-modern">
                    <div class="form-header">
                        <h3>
                            <i class="fas fa-balance-scale"></i>
                            Kelola Bobot Kriteria
                        </h3>
                        <p class="subtitle">Atur bobot untuk setiap kriteria penilaian sistem STARS</p>
                    </div>

                    <!-- Meta tag for CSRF token -->
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger-modern alert-modern">
                            <strong><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success-modern alert-modern">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form id="formBobot" action="{{ route('admin.kelolaBobot.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-list-alt"></i> Kriteria</th>
                                        <th><i class="fas fa-weight-hanging"></i> Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bobots as $index => $bobot)
                                        <tr>
                                            <td>
                                                <div class="kriteria-label">
                                                    <div class="kriteria-icon">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    {{ $bobot->kriteria }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="bobot-input-group">
                                                    <input type="number" 
                                                           step="0.01" 
                                                           min="0" 
                                                           max="1"
                                                           name="bobot[{{ $bobot->id }}]" 
                                                           value="{{ $bobot->bobot }}" 
                                                           class="form-control form-control-modern bobot-input"
                                                           data-kriteria="{{ $bobot->kriteria }}">
                                                    <span class="bobot-percentage">
                                                        (<span class="percentage-value">{{ $bobot->bobot * 100 }}</span>%)
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="total-info" id="totalInfo">
                            <i class="fas fa-calculator"></i>
                            Total Bobot: <span id="totalBobot">0</span> 
                            (<span id="totalPercentage">0</span>%)
                            <small id="validationMessage" class="d-block mt-1"></small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-save-modern" id="submitBtn">
                                <span class="loading-spinner"></span>
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                            <div id="errorMessage" class="mt-3" style="display: none;">
                                <div class="alert alert-danger-modern alert-modern">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Tidak dapat menyimpan!</strong><br>
                                    <span id="errorText"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.js"></script>

<script>
$(document).ready(function () {
    // Function to calculate total weight
    function calculateTotal() {
        let total = 0;
        $('.bobot-input').each(function() {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        
        $('#totalBobot').text(total.toFixed(2));
        $('#totalPercentage').text((total * 100).toFixed(1));
        
        // Validation message and button state
        let message = '';
        let messageClass = '';
        let submitBtn = $('#submitBtn');
        let totalInfo = $('#totalInfo');
        let errorMessage = $('#errorMessage');
        
        // Remove previous classes
        totalInfo.removeClass('error success');
        
        if (total < 0.99) {
            message = '⚠️ Total bobot kurang dari 100%';
            messageClass = 'text-warning';
            submitBtn.prop('disabled', true);
            totalInfo.addClass('error');
            errorMessage.show();
            $('#errorText').text('Total bobot harus tepat 100% (1.00). Saat ini total bobot adalah ' + (total * 100).toFixed(1) + '%');
        } else if (total > 1.01) {
            message = '❌ Total bobot melebihi 100%! Tidak dapat disimpan.';
            messageClass = 'text-danger';
            submitBtn.prop('disabled', true);
            totalInfo.addClass('error');
            errorMessage.show();
            $('#errorText').text('Total bobot tidak boleh melebihi 100%. Saat ini total bobot adalah ' + (total * 100).toFixed(1) + '%');
        } else {
            message = '✅ Total bobot sudah sesuai';
            messageClass = 'text-success';
            submitBtn.prop('disabled', false);
            totalInfo.addClass('success');
            errorMessage.hide();
        }
        
        $('#validationMessage').text(message).attr('class', 'd-block mt-1 ' + messageClass);
    }
    
    // Update percentage display and total when input changes
    $('.bobot-input').on('input', function() {
        let value = parseFloat($(this).val()) || 0;
        let percentage = (value * 100).toFixed(1);
        $(this).siblings('.bobot-percentage').find('.percentage-value').text(percentage);
        calculateTotal();
    });
    
    // Initial calculation
    calculateTotal();
    
    // Form submission with AJAX
    $('#formBobot').submit(function (e) {
        e.preventDefault();
        
        // Double check validation before submitting
        let total = 0;
        $('.bobot-input').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        
        if (total > 1.01) {
            // Show error notification
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Dapat Menyimpan!',
                    text: `Total bobot melebihi 100% (${(total * 100).toFixed(1)}%). Silakan sesuaikan bobot terlebih dahulu.`,
                    confirmButtonColor: '#ff416c'
                });
            } else {
                alert(`Tidak dapat menyimpan! Total bobot melebihi 100% (${(total * 100).toFixed(1)}%). Silakan sesuaikan bobot terlebih dahulu.`);
            }
            return false;
        }
        
        if (total < 0.99) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Total Bobot Kurang!',
                    text: `Total bobot hanya ${(total * 100).toFixed(1)}%. Pastikan total bobot adalah 100%.`,
                    confirmButtonColor: '#ffa726'
                });
            } else {
                alert(`Total bobot kurang! Total bobot hanya ${(total * 100).toFixed(1)}%. Pastikan total bobot adalah 100%.`);
            }
            return false;
        }
        
        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();
        let submitBtn = form.find('button[type="submit"]');
        let spinner = submitBtn.find('.loading-spinner');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.show();
        
        $.ajax({
            type: "PUT",
            url: url,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#notifArea').html(`
                    <div class="alert alert-success-modern alert-modern fade-in">
                        <i class="fas fa-check-circle"></i> 
                        ${response.message ?? 'Bobot berhasil diperbarui.'}
                    </div>
                `);
                
                // Show success notification
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Bobot kriteria berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false,
                        confirmButtonColor: '#667eea'
                    });
                }
                
                // Scroll to notification
                $('html, body').animate({
                    scrollTop: $("#notifArea").offset().top - 100
                }, 500);
                
                // Auto hide notification after 5 seconds
                setTimeout(() => {
                    $('#notifArea .alert').fadeOut();
                }, 5000);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                let message = 'Terjadi kesalahan saat menyimpan.';
                
                if (response?.errors) {
                    let errors = Object.values(response.errors).flat().join('<br>');
                    message = errors;
                }
                
                $('#notifArea').html(`
                    <div class="alert alert-danger-modern alert-modern fade-in">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Error:</strong><br>
                        ${message}
                    </div>
                `);
                
                // Show error notification
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan!',
                        text: message,
                        confirmButtonColor: '#ff416c'
                    });
                }
                
                // Scroll to notification
                $('html, body').animate({
                    scrollTop: $("#notifArea").offset().top - 100
                }, 500);
            },
            complete: function() {
                // Hide loading state and recalculate to restore button state
                spinner.hide();
                calculateTotal();
            }
        });
    });
    
    // Add hover effects to input fields
    $('.bobot-input').hover(
        function() {
            $(this).parent().addClass('shadow-sm');
        },
        function() {
            $(this).parent().removeClass('shadow-sm');
        }
    );
});
</script>
@endpush