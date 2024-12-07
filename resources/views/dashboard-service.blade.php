<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}" />
    <title>Dashboard Service</title>
</head>

<body>
    <nav class="sidenav">
        <a href="#">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('dashboard') }}">
            <div>
                <i class="fa-solid fa-house"></i>
                <p class="poppins-semibold">Dashboard</p>
            </div>
        </a>
        <a href="/dashboard-service">
            <div>
                <i class="fa-solid fa-plus"></i>
                <p class="poppins-semibold">Add Service</p>
            </div>
        </a>
        <a href="/dashboard-edit">
            <div>
                <i class="fa-solid fa-pen"></i>
                <p class="poppins-semibold">Edit Service</p>
            </div>
        </a>
        <a href="/dashboard-print">
            <div>
                <i class="fa-solid fa-print"></i>
                <p class="poppins-semibold">Print Service</p>
            </div>
        </a>
    </nav>

    <section class="dashboard">
        <div class="dashboard-header">
            <h1 class="poppins-semibold">Add Service</h1>
        </div>
        <div class="dashboard-content">
            <div class="dashboard-top">
                <div class="dashboard-top-item">
                    <img src="/img/insurance.png" style="max-width: 60px; max-height: 60px;" alt="">
                    <div>
                        <h1 class="poppins-semibold" style="font-size: 20px;">Package Insurance</h1>
                        <p class="poppins-regular" style="color: #718EBF; margin-top: 10px;">Unlimited protection</p>
                    </div>
                </div>
                <div class="dashboard-top-item">
                    <img src="/img/rent.png" style="max-width: 60px; max-height: 60px;" alt="">
                    <div>
                        <h1 class="poppins-semibold" style="font-size: 20px;">Rent</h1>
                        <p class="poppins-regular" style="color: #718EBF; margin-top: 10px;">Rent. Think. Grow</p>
                    </div>
                </div>
                <div class="dashboard-top-item">
                    <img src="/img/safety.png" style="max-width: 60px; max-height: 60px;" alt="">
                    <div>
                        <h1 class="poppins-semibold" style="font-size: 20px;">Safety</h1>
                        <p class="poppins-regular" style="color: #718EBF; margin-top: 10px;">We are your allies</p>
                    </div>
                </div>
            </div>
            <div class="dashboard-bottom">
                <div class="services-container poppins-semibold">
                    <h1 class="services-title">Rent Form</h1>
                    <div class="service-card">
                        <form action="{{ route('dashboard-service-process') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_layanan">Nama Layanan</label>
                                <input type="text" name="nama_layanan" id="nama_layanan" placeholder="Masukkan nama layanan"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi Layanan" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_permintaan">Tanggal Permintaan</label>
                                <input type="date" name="tanggal_permintaan" id="tanggal_permintaan" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required>
                                    <option value="" disabled selected>Pilih status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
