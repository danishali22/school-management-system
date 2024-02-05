<?php
session_start();
if (!(isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == TRUE)) {
    header('Location: ../login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php $title = "Panel"; ?>
    <title>Admin | <?= $title ?></title>

    <!-- Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500&family=Mulish:ital@1&family=Roboto&display=swap" rel="stylesheet">


    <!-- Sweet Alert  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS (optional) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- Multi Select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

    <!-- Data Table Jquery  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        .main-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        body {
            overflow-x: hidden;
        }

        /* Google Fonts */

        /* Google Font For heading */
        .my-heading {
            font-family: 'Baloo Paaji 2', cursive;
            font-family: 'Mulish', sans-serif;
            font-family: 'Roboto', sans-serif;
            text-align: center;
            font-size: 2rem;
            color: #fff;
            padding: 20px 0;
            margin: 0;
            transition: transform 0.3s ease-in-out;
        }

        .my-heading:hover {
            transform: scale(1.1);
            background-color: #0056b3;
        }



        /* Style the table header */
        /* Add this CSS for borders on rows and columns */
        .my-table {
            /* border: 1px solid #dee2e6; */
            border-collapse: collapse;
            border-radius: 10px;
            width: 100%;
        }

        .my-table th,
        .my-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            /* Add borders to cells */
        }

        .my-table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }

        /* Alternate Row Background Color */
        .my-table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Hover Effect with Transition */
        .my-table tbody tr:hover {
            background-color: #dcdcdc;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Optional: Style the table header cells */
        .my-table th {
            border-top: none;
        }

        /* Animation for hover effect on rows */
        .my-table tbody tr:hover td {
            transform: scale(1.05);
            transition: transform 0.2s ease;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }

        /* Add a transition for the box shadow */
        .my-table tbody tr td {
            transition: box-shadow 0.3s ease;
        }
    </style>

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">