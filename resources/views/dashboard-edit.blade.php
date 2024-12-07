<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./css/fonts.css" />
    <link rel="stylesheet" href="./css/dashboard.style.css" />
    <title>Dashboard</title>
</head>

<body>
    <nav class="sidenav">
        <a href="">
            <img src="img/logo.png" alt="">
        </a>
        <a href="/dashboard.php">
            <div>
                <i class="fa-solid fa-house"></i>
                <p class="poppins-semibold">Dashboard</p>
            </div>
        </a>
        <a href="/dashboard-service.php">
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
            <h1 class="poppins-semibold">Edit Service</h1>
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
                    <h1 class="services-title">Rent Listings</h1>

                    <table class="service-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Layanan</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Permintaan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $key => $request)
                                <tr id="row-{{ $request->request_id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <input type="text" value="{{ $request->nama_layanan }}"
                                            id="nama-{{ $request->request_id }}" disabled>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $request->deskripsi }}"
                                            id="deskripsi-{{ $request->request_id }}" disabled>
                                    </td>
                                    <td>
                                        <input type="date" value="{{ $request->tanggal_permintaan }}"
                                            id="tanggal-{{ $request->request_id }}" disabled>
                                    </td>
                                    <td>
                                        <select id="status-{{ $request->request_id }}" disabled>
                                            <option value="Pending"
                                                {{ $request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Confirmed"
                                                {{ $request->status == 'Confirmed' ? 'selected' : '' }}>Confirmed
                                            </option>
                                            <option value="Completed"
                                                {{ $request->status == 'Completed' ? 'selected' : '' }}>Completed
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn-edit" data-id="{{ $request->request_id }}">Edit</button>
                                        <button class="btn-save" data-id="{{ $request->request_id }}"
                                            style="display:none;">Save</button>
                                        <button class="btn-delete" data-id="{{ $request->request_id }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.btn-edit');
            const saveButtons = document.querySelectorAll('.btn-save');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');

                    document.getElementById(`nama-${id}`).disabled = false;
                    document.getElementById(`deskripsi-${id}`).disabled = false;
                    document.getElementById(`tanggal-${id}`).disabled = false;
                    document.getElementById(`status-${id}`).disabled = false;

                    button.style.display = 'none';
                    document.querySelector(`.btn-save[data-id='${id}']`).style.display =
                        'inline-block';
                });
            });

            saveButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const nama = document.getElementById(`nama-${id}`).value;
                    const deskripsi = document.getElementById(`deskripsi-${id}`).value;
                    const tanggal = document.getElementById(`tanggal-${id}`).value;
                    const status = document.getElementById(`status-${id}`).value;

                    fetch('/update-request', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                id,
                                nama,
                                deskripsi,
                                tanggal,
                                status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Update successful!');
                            } else {
                                alert('Update failed!');
                            }

                            document.getElementById(`nama-${id}`).disabled = true;
                            document.getElementById(`deskripsi-${id}`).disabled = true;
                            document.getElementById(`tanggal-${id}`).disabled = true;
                            document.getElementById(`status-${id}`).disabled = true;

                            button.style.display = 'none';
                            document.querySelector(`.btn-edit[data-id='${id}']`).style.display =
                                'inline-block';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const id = this.dataset.id;
                    const row = document.getElementById(`row-${id}`);

                    if (confirm("Are you sure you want to delete this record?")) {
                        fetch('/delete-request', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    id: id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Record deleted successfully');
                                    row.remove();
                                } else {
                                    alert('Failed to delete record');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('There was an error while deleting the record.');
                            });
                    }
                });
            });
        });
    </script>
</body>

</html>
