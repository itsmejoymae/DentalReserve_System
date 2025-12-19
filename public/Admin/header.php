<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental - Your Smile Our Priority</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
</head>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px) rotateX(-10deg); }
        to { opacity: 1; transform: translateY(0) rotateX(0); }
    }

    .perspective-container {
        perspective: 1200px;
    }

    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    /* Staggered animation for cards */
    .card-3d:nth-child(1) { animation-delay: 0.1s; }
    .card-3d:nth-child(2) { animation-delay: 0.2s; }
    .card-3d:nth-child(3) { animation-delay: 0.3s; }
    .card-3d:nth-child(4) { animation-delay: 0.4s; }

    .card-3d:hover {
        transform: translateY(-12px) rotateX(5deg) rotateY(-2deg);
        box-shadow: 
            -1px 1px 0px #e2e8f0,
            -2px 2px 0px #e2e8f0,
            -3px 3px 0px #e2e8f0,
            -15px 20px 30px rgba(0,0,0,0.1);
    }

    .card-inner {
        transform: translateZ(20px);
    }

    .glass-icon {
        backdrop-filter: blur(4px);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: inset 0 0 10px rgba(255,255,255,0.5);
    }
</style>
<body class="bg-sky-100 text-gray-800">