<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3D PDF Flipbook</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            text-align: center;
            transition: background 0.4s, color 0.4s;
        }

        body.dark {
            background: #121212;
            color: #f0f0f0;
        }

        #flipbook {
            width: 800px;
            height: 500px;
            margin: 20px auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            transition: transform 0.2s ease-in-out;
        }

        .page {
            box-shadow: inset 0 0 10px rgba(0,0,0,0.2), 5px 5px 15px rgba(0,0,0,0.2);
            transform-origin: left center;
            transition: transform 1.2s ease;
            background: #fff;
            border-radius: 4px;
        }


        /*.page {*/
        /*    width: 400px;*/
        /*    height: 500px;*/
        /*    background: white;*/
        /*    overflow: hidden;*/
        /*}*/

        .page:hover {
            transform: rotateY(-3deg) scale(1.01);
        }


        body.dark .page {
            background: #333;
        }

        .page img {
            width: 100%;
            height: auto;
        }

        .controls {
            margin-top: 20px;
        }

        .controls button {
            padding: 10px 20px;
            margin: 0 5px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s;
        }

        body.dark .controls button {
            background: #555;
        }

        .controls button:hover {
            background: #555;
        }

        #page-indicator {
            margin-top: 10px;
            font-size: 16px;
        }

        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            font-size: 24px;
        }

        body.dark #preloader {
            background: rgba(0, 0, 0, 0.7);
            color: white;
        }
    </style>
</head>
<body>

    <div id="preloader">Loading PDF...</div>
    <div id="flipbook"></div>

    <div class="controls">
        <button onclick="prevPage()">⬅ Prev</button>
        <button onclick="nextPage()">Next ➡</button>
        <button onclick="startAutoFlip()">▶ Auto Flip</button>
        <button onclick="stopAutoFlip()">⏹ Stop Auto</button>
        <button onclick="toggleFullscreen()">🖥 Fullscreen</button>
        <button onclick="zoomIn()">🔍 Zoom In</button>
        <button onclick="zoomOut()">🔎 Zoom Out</button>
        <button onclick="toggleDarkMode()">🌙 Toggle Dark</button>
    </div>

    <div id="page-indicator">Page 0 / 0</div>
    <input type="range" id="page-slider" min="1" value="1" style="width: 60%; margin: 10px auto; display: block;" />


    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery3.6.min.js') }}"></script>
    <script src="{{ asset('assets/js/turn.3.js') }}"></script>
    <script src="{{ asset('assets/js/pdf.min.js') }}"></script>

    @include("3d.js")
</body>
</html>
