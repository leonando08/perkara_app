<?php
defined('BASEPATH') or exit('No direct script access allowed');
$username = $this->session->userdata('username');
$role     = $this->session->userdata('role');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perkara</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts - Professional Typography System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Global Typography System -->
    <link href="<?= base_url('assets/css/global-typography.css'); ?>" rel="stylesheet" />

    <!-- GLOBAL LAYOUT SYSTEM - Controls main content positioning -->
    <link href="<?= base_url('assets/css/global-layout.css?v=' . time()); ?>" rel="stylesheet" />

    <style>
        :root {
            --font-primary: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-heading: 'Poppins', sans-serif;
            --font-mono: 'JetBrains Mono', 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;

            /* Typography Scale */
            --text-xs: 0.75rem;
            /* 12px */
            --text-sm: 0.875rem;
            /* 14px */
            --text-base: 1rem;
            /* 16px */
            --text-lg: 1.125rem;
            /* 18px */
            --text-xl: 1.25rem;
            /* 20px */
            --text-2xl: 1.5rem;
            /* 24px */
            --text-3xl: 1.875rem;
            /* 30px */
            --text-4xl: 2.25rem;
            /* 36px */

            /* Font Weights */
            --font-light: 300;
            --font-normal: 400;
            --font-medium: 500;
            --font-semibold: 600;
            --font-bold: 700;
            --font-extrabold: 800;

            /* Line Heights */
            --leading-tight: 1.25;
            --leading-normal: 1.5;
            --leading-relaxed: 1.625;
            --leading-loose: 2;
        }

        * {
            font-family: var(--font-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        body {
            font-family: var(--font-primary);
            font-size: var(--text-base);
            line-height: var(--leading-normal);
            color: #2d3748;
            background-color: #f8f9fa;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
            box-sizing: border-box;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
            line-height: var(--leading-tight);
            color: #1a202c;
            margin-bottom: 0.5em;
        }

        h1 {
            font-size: var(--text-4xl);
            font-weight: var(--font-bold);
        }

        h2 {
            font-size: var(--text-3xl);
            font-weight: var(--font-bold);
        }

        h3 {
            font-size: var(--text-2xl);
            font-weight: var(--font-semibold);
        }

        h4 {
            font-size: var(--text-xl);
            font-weight: var(--font-semibold);
        }

        h5 {
            font-size: var(--text-lg);
            font-weight: var(--font-medium);
        }

        h6 {
            font-size: var(--text-base);
            font-weight: var(--font-medium);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Paragraph and Text */
        p {
            font-family: var(--font-primary);
            line-height: var(--leading-relaxed);
            margin-bottom: 1rem;
        }

        .lead {
            font-size: var(--text-lg);
            font-weight: var(--font-normal);
            line-height: var(--leading-relaxed);
        }

        .small,
        small {
            font-size: var(--text-sm);
        }

        /* Button Typography */
        .btn {
            font-family: var(--font-primary);
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            letter-spacing: 0.025em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            border: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-lg {
            font-size: var(--text-base);
            padding: 0.75rem 1.5rem;
        }

        .btn-sm {
            font-size: var(--text-xs);
            padding: 0.5rem 1rem;
        }

        /* Form Elements Typography */
        .form-control,
        .form-select {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
            font-weight: var(--font-normal);
            line-height: var(--leading-normal);
        }

        .form-label {
            font-family: var(--font-primary);
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .form-text {
            font-size: var(--text-xs);
            color: #6b7280;
        }

        /* Table Typography */
        .table {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
        }

        .table th {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            font-weight: var(--font-normal);
        }

        /* Data Fields (Nomor Perkara, Tanggal, etc.) */
        .data-field,
        .nomor-perkara,
        .tanggal,
        .numeric-data,
        code,
        pre {
            font-family: var(--font-mono);
            font-size: var(--text-sm);
            font-weight: var(--font-normal);
        }

        /* Navbar Typography */
        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
            font-size: var(--text-lg);
        }

        .navbar-text {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
        }

        /* Badge Typography */
        .badge {
            font-family: var(--font-primary);
            font-weight: var(--font-medium);
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        /* Alert Typography */
        .alert {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
        }

        .alert-heading {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
        }

        /* Card Typography */
        .card-title {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
        }

        .card-subtitle {
            font-family: var(--font-primary);
            font-weight: var(--font-normal);
        }

        .card-text {
            font-family: var(--font-primary);
            line-height: var(--leading-relaxed);
        }

        /* Breadcrumb Typography */
        .breadcrumb {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
        }

        /* List Group Typography */
        .list-group-item {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
        }

        /* Dropdown Typography */
        .dropdown-item {
            font-family: var(--font-primary);
            font-size: var(--text-sm);
        }

        /* Modal Typography */
        .modal-title {
            font-family: var(--font-heading);
            font-weight: var(--font-semibold);
        }

        .modal-body {
            font-family: var(--font-primary);
            line-height: var(--leading-relaxed);
        }

        /* Utility Classes */
        .font-mono {
            font-family: var(--font-mono);
        }

        .font-heading {
            font-family: var(--font-heading);
        }

        .font-primary {
            font-family: var(--font-primary);
        }

        .text-xs {
            font-size: var(--text-xs);
        }

        .text-sm {
            font-size: var(--text-sm);
        }

        .text-base {
            font-size: var(--text-base);
        }

        .text-lg {
            font-size: var(--text-lg);
        }

        .text-xl {
            font-size: var(--text-xl);
        }

        .text-2xl {
            font-size: var(--text-2xl);
        }

        .text-3xl {
            font-size: var(--text-3xl);
        }

        .text-4xl {
            font-size: var(--text-4xl);
        }

        .font-light {
            font-weight: var(--font-light);
        }

        .font-normal {
            font-weight: var(--font-normal);
        }

        .font-medium {
            font-weight: var(--font-medium);
        }

        .font-semibold {
            font-weight: var(--font-semibold);
        }

        .font-bold {
            font-weight: var(--font-bold);
        }

        .font-extrabold {
            font-weight: var(--font-extrabold);
        }

        /* Responsive Typography */
        @media (max-width: 768px) {
            body {
                font-size: var(--text-sm);
            }

            h1 {
                font-size: var(--text-3xl);
            }

            h2 {
                font-size: var(--text-2xl);
            }

            h3 {
                font-size: var(--text-xl);
            }

            h4 {
                font-size: var(--text-lg);
            }

            h5 {
                font-size: var(--text-base);
            }

            h6 {
                font-size: var(--text-sm);
            }

            .navbar-brand {
                font-size: var(--text-base);
            }

            .btn {
                font-size: var(--text-xs);
                padding: 0.5rem 1rem;
            }
        }

        /* ==============================================
           EXISTING STYLES (Updated with new typography)
           ============================================== */

        /* Main Content Layout - Now handled by global-layout.css */

        .content-wrapper {
            padding: 15px 0 15px 0;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
            max-width: 100%;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        /* Table Container */
        .table-wrapper {
            position: relative;
            margin-bottom: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table-responsive {
            overflow: auto;
            margin: 0;
            padding: 0;
            max-width: 100%;
            max-height: 70vh;
            position: relative;
            scroll-behavior: smooth;
        }

        .table {
            width: max-content;
            min-width: 100%;
            margin-bottom: 0;
            background-color: white;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
        }

        /* Reset semua kolom untuk tidak sticky */
        .table th,
        .table td {
            position: static !important;
            left: auto !important;
            right: auto !important;
        }

        /* Sticky Header */
        .table thead {
            background-color: #198754;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table thead th {
            background-color: #198754;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
            white-space: nowrap;
            background-color: white;
        }

        .table tbody tr:hover td {
            background-color: rgba(25, 135, 84, 0.05);
            transition: background-color 0.2s ease;
        }

        /* Column Widths */
        .table .number-column {
            min-width: 60px;
            max-width: 60px;
            text-align: center;
        }

        .table .text-column {
            min-width: 150px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table .parent-column {
            min-width: 120px;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table .date-column {
            min-width: 130px;
            max-width: 130px;
        }

        .table .status-column {
            min-width: 100px;
            max-width: 100px;
            text-align: center;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-success {
            background-color: #198754;
            color: white;
        }

        .btn-success:hover {
            background-color: #157347;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(25, 135, 84, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }

        /* Badge */
        .badge {
            padding: 0.4rem 0.75rem;
            font-weight: 500;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-success {
            background-color: #198754 !important;
            color: white !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }

        /* Form controls */
        .form-control {
            padding: 0.625rem 0.875rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
            outline: none;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.875rem;
        }

        /* Scrollbar styling */
        .table-responsive::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f3f4;
            border-radius: 8px;
            margin: 2px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #198754, #157347);
            border-radius: 8px;
            border: 1px solid #f1f3f4;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #157347, #0d4b2e);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                padding: 1rem;
            }

            .table-responsive {
                max-height: 60vh;
            }

            .table {
                font-size: 0.813rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .table-responsive {
                max-height: 55vh;
            }

            .table thead th,
            .table tbody td {
                padding: 0.375rem;
                font-size: 0.8rem;
            }
        }

        .table-container {
            overflow-x: auto;
            margin: 0;
            padding: 1.5rem;
            border-radius: 12px;
            height: 100%;
            width: 100%;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        .table-container::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #666;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            background: #ffffff;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table>thead {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .table>thead>tr>th {
            background: linear-gradient(135deg, #006400, #004d00);
            color: white;
            font-weight: 500;
            text-align: center;
            padding: 1rem 0.75rem;
            white-space: nowrap;
            vertical-align: middle;
            position: sticky;
            top: 0;
            min-width: 100px;
            /* Base minimum width for all columns */
        }

        .table>thead>tr>th:first-child {
            left: 0;
            z-index: 3;
        }

        .table>tbody>tr>td {
            vertical-align: middle;
            padding: 0.75rem;
            font-size: 0.875rem;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

        .table>tbody>tr:hover>td {
            background-color: rgba(0, 100, 0, 0.02);
        }

        /* Column width classes */
        .table .col-xs {
            min-width: 50px;
        }

        .table .col-sm {
            min-width: 100px;
        }

        .table .col-md {
            min-width: 150px;
        }

        .table .col-lg {
            min-width: 200px;
        }

        .table .col-xl {
            min-width: 250px;
        }

        /* Special column types */
        .table td.fit-content {
            white-space: nowrap;
            width: 1%;
            min-width: unset;
            /* Override min-width for fit-content */
        }

        .table td.wrap-text {
            white-space: normal;
            word-wrap: break-word;
            min-width: 200px;
        }

        /* Fixed first column */
        .table th:first-child,
        .table td:first-child {
            position: sticky;
            left: 0;
            z-index: 1;
        }

        .table td:first-child {
            background: inherit;
        }

        /* Ensure fixed column maintains its background when hovered */
        .table>tbody>tr:hover>td:first-child {
            background-color: rgba(0, 100, 0, 0.02);
        }

        /* Main content scrolling */
        /* Main content layout handled by global-layout.css */

        .content-wrapper {
            width: 100%;
            padding: 0;
        }

        /* Card Styles */
        .content-card {
            background: #ffffff;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Table Styles */
        .table-container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            margin-top: 1rem;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table> :not(caption)>*>* {
            padding: 0.75rem;
        }

        .table thead th {
            background: linear-gradient(135deg, #006400, #004d00);
            color: white;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            padding: 1rem 0.75rem;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 100, 0, 0.02);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        /* Form Styles */
        .search-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .search-card .form-group {
            margin-bottom: 1rem;
        }

        .search-card .btn {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .form-label {
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
        }

        .form-control:focus {
            border-color: #006400;
            box-shadow: 0 0 0 2px rgba(0, 100, 0, 0.1);
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #006400, #004d00);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #005000, #003d00);
            transform: translateY(-1px);
        }

        /* Action Buttons */
        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }

        .btn-warning {
            color: #000;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            color: #000;
            background-color: #ffca2c;
            border-color: #ffc720;
            transform: translateY(-1px);
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            color: #fff;
            background-color: #bb2d3b;
            border-color: #b02a37;
            transform: translateY(-1px);
        }

        /* Small screens */
        @media (max-width: 576px) {
            .btn-group-sm>.btn {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .table-container {
                padding: 0.5rem;
            }

            .table>thead>tr>th,
            .table>tbody>tr>td {
                padding: 0.5rem 0.25rem;
                font-size: 0.8rem;
            }
        }

        /* Badge Styles */
        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {

            .content-card,
            .search-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .table-container {
                padding: 0.5rem;
                margin-top: 0.5rem;
            }

            .table thead th {
                padding: 0.75rem 0.5rem;
            }
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #006400, #004d00);
            padding: 0.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            height: 60px;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1046;
        }

        .navbar-brand {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 32px;
            width: auto;
            border-radius: 4px;
        }

        .navbar-text {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-logout {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.375rem 1rem;
            font-size: 0.875rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        /* User Profile Dropdown Styles */
        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-toggle {
            border: none !important;
            background: transparent !important;
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .dropdown-toggle:hover,
        .dropdown-toggle:focus {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2);
        }

        .dropdown-toggle:active {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            min-width: 250px;
            margin-top: 0.5rem;
            animation: dropdownFadeIn 0.2s ease-out;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            display: none;
            background-color: #fff;
            z-index: 1050;
        }

        .dropdown-menu.show {
            display: block !important;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-header {
            font-weight: 600;
            color: #495057;
            padding: 0.75rem 1rem 0.5rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
        }

        .dropdown-item {
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #006400;
        }

        .dropdown-item:focus {
            background-color: #f8f9fa;
            color: #006400;
            outline: none;
        }

        .dropdown-item.text-danger:hover,
        .dropdown-item.text-danger:focus {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .dropdown-item i {
            width: 1.25rem;
            text-align: center;
            opacity: 0.7;
            margin-right: 0.5rem;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e5e7eb;
        }

        /* Main Content Area */
        /* Main content positioning is handled by sidebar.php */

        .container-fluid {
            padding: 0 5px;
            width: 100%;
        }

        @media (max-width: 768px) {

            /* Mobile responsive handled by sidebar.php */
            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand img {
                height: 28px;
            }

            .navbar-text {
                display: none;
            }
        }

        /* Loading Overlay */
        #loadingOverlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Spinner customization */
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.25rem;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #666;
        }

        /* Empty State */
        .empty-state {
            padding: 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading overlay handling
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Show loading on form submit
            document.querySelector('form').addEventListener('submit', function() {
                loadingOverlay.classList.remove('d-none');
            });

            // Handle links with confirmation
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a[onclick*="confirm"]');
                if (target && !target.dataset.handled) {
                    target.dataset.handled = true;
                    target.addEventListener('click', function() {
                        if (confirm(this.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?')) {
                            loadingOverlay.classList.remove('d-none');
                            return true;
                        }
                        return false;
                    });
                }
            });

            // Table cell tooltips for truncated content
            document.querySelectorAll('.wrap-text').forEach(cell => {
                const content = cell.textContent;
                if (cell.scrollWidth > cell.clientWidth) {
                    cell.title = content;
                }
            });
        });
    </script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link text-white d-lg-none me-2 p-0" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?= $role == 'admin' ? site_url('admin/dashboard_admin') : site_url('user/dashboard_user') ?>">
                <img src="https://sepeda.pt-banjarmasin.go.id/assets/logo.ico" alt="Logo">
                <span class="d-none d-sm-inline">Sistem Informasi Perkara</span>
                <span class="d-sm-none">SIP</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-link text-white dropdown-toggle d-flex align-items-center"
                        type="button"
                        id="userDropdown"
                        aria-expanded="false"
                        onclick="console.log('Dropdown button clicked directly!')">
                        <i class="fas fa-user-circle me-2" style="font-size: 1.5rem;"></i>
                        <div class="d-flex flex-column align-items-start">
                            <span class="fw-medium"><?= htmlspecialchars($username); ?></span>
                            <small class="text-white-50"><?= ucfirst(htmlspecialchars($role)); ?></small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header">
                                <i class="fas fa-user-circle me-2"></i>
                                <?= htmlspecialchars($username); ?>
                            </h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('profile'); ?>">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('profile/edit'); ?>">
                                <i class="fas fa-edit me-2"></i>
                                Edit Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('profile/change_password'); ?>">
                                <i class="fas fa-key me-2"></i>
                                Ubah Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php if ($role === 'admin'): ?>
                            <li>
                                <a class="dropdown-item" href="<?= site_url('admin/dashboard_admin'); ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Dashboard Admin
                                </a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a class="dropdown-item" href="<?= site_url('user/dashboard_user'); ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Dashboard User
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= site_url('auth/logout'); ?>" onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <?php require_once(APPPATH . 'views/navbar/sidebar.php'); ?>

    <!-- Bootstrap JS (needed for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript for dropdown functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up dropdown...');

            const dropdownToggle = document.getElementById('userDropdown');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            if (dropdownToggle && dropdownMenu) {
                console.log('Dropdown elements found');

                // Click event for dropdown toggle
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('Dropdown clicked!');

                    // Toggle dropdown
                    if (dropdownMenu.classList.contains('show')) {
                        dropdownMenu.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdownMenu.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                        dropdownToggle.setAttribute('aria-expanded', 'false');
                    }
                });

                // Handle dropdown item clicks
                const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
                dropdownItems.forEach(function(item) {
                    item.addEventListener('click', function(e) {
                        console.log('Dropdown item clicked:', this.href);

                        if (this.href) {
                            window.location.href = this.href;
                        }
                    });
                });

                console.log('Dropdown setup complete');
            } else {
                console.error('Dropdown elements not found!');
            }
        });
    </script>
