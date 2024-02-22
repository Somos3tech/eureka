<!DOCTYPE html>
<html lang="es">

<head>
    <script>
        (function() {
            function ready(fn) {
                if (document.readyState != 'loading') {
                    fn();
                } else {
                    document.addEventListener('DOMContentLoaded', fn);
                }
            }

            function makeSnow(el) {
                var ctx = el.getContext('2d');
                var width = 0;
                var height = 0;
                var particles = [];

                var Particle = function() {
                    this.x = this.y = this.dx = this.dy = 0;
                    this.reset();
                }

                Particle.prototype.reset = function() {
                    this.y = Math.random() * height;
                    this.x = Math.random() * width;
                    this.dx = (Math.random() * 1) - 0.5;
                    this.dy = (Math.random() * 0.5) + 0.5;
                }

                function createParticles(count) {
                    if (count != particles.length) {
                        particles = [];
                        for (var i = 0; i < count; i++) {
                            particles.push(new Particle());
                        }
                    }
                }

                function onResize() {
                    width = window.innerWidth;
                    height = window.innerHeight;
                    el.width = width;
                    el.height = height;

                    createParticles((width * height) / 10000);
                }

                function updateParticles() {
                    ctx.clearRect(0, 0, width, height);
                    ctx.fillStyle = '#f6f9fa';

                    particles.forEach(function(particle) {
                        particle.y += particle.dy;
                        particle.x += particle.dx;

                        if (particle.y > height) {
                            particle.y = 0;
                        }

                        if (particle.x > width) {
                            particle.reset();
                            particle.y = 0;
                        }

                        ctx.beginPath();
                        ctx.arc(particle.x, particle.y, 5, 0, Math.PI * 2, false);
                        ctx.fill();
                    });

                    window.requestAnimationFrame(updateParticles);
                }

                onResize();
                updateParticles();

                window.addEventListener('resize', onResize);
            }

            ready(function() {
                var canvas = document.getElementById('snow');
                makeSnow(canvas);
            });
        })();
    </script>
    <style>
        html,
        body {
            height: 100%;
            min-height: 450px;
            font-family: "Dosis", sans-serif;
            font-size: 32px;
            font-weight: 500;
            color: #5d7399;
        }

        .content {
            height: 100%;
            position: relative;
            z-index: 1;
            background-color: #d2e1ec;
            background-image: linear-gradient(to bottom, #bbcfe1 0%, #e8f2f6 80%);
            overflow: hidden;
        }

        .snow {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 20;
        }

        .main-text {
            padding: 20vh 20px 0 20px;
            text-align: center;
            line-height: 2em;
            font-size: 5vh;
        }

        .home-link {
            font-size: 0.6em;
            font-weight: 400;
            color: inherit;
            text-decoration: none;
            opacity: 0.6;
            border-bottom: 1px dashed rgba(93, 115, 153, 0.5);
        }

        .home-link:hover {
            opacity: 1;
        }

        .ground {
            height: 160px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            background: #f6f9fa;
            box-shadow: 0 0 10px 10px #f6f9fa;
        }

        .ground:before,
        .ground:after {
            content: "";
            display: block;
            width: 250px;
            height: 250px;
            position: absolute;
            top: -62.5px;
            z-index: -1;
            background: transparent;
            transform: scaleX(0.2) rotate(45deg);
        }

        .ground:after {
            left: 50%;
            margin-left: -166.6666666667px;
            box-shadow: -255px 345px 15px #97a6c0, -595px 605px 15px #94a3be, -910px 890px 15px #94a3be, -1230px 1170px 15px #bac4d5, -1455px 1545px 15px #9aa9c2, -1760px 1840px 15px #7e90b0, -2140px 2060px 15px #9aa9c2, -2370px 2430px 15px #9dabc4, -2655px 2745px 15px #b7c1d3, -3045px 2955px 15px #8193b2, -3300px 3300px 15px #a7b4c9, -3630px 3570px 15px #9dabc4, -3875px 3925px 15px #b4bed1, -4220px 4180px 15px #8a9bb8, -4495px 4505px 15px #b4bed1, -4830px 4770px 15px #94a3be;
        }

        .ground:before {
            right: 50%;
            margin-right: -166.6666666667px;
            box-shadow: 255px -345px 15px #a4b1c8, 630px -570px 15px #9aa9c2, 855px -945px 15px #adb9cd, 1245px -1155px 15px #8798b6, 1525px -1475px 15px #9aa9c2, 1795px -1805px 15px #91a1bc, 2125px -2075px 15px #b0bccf, 2385px -2415px 15px #97a6c0, 2665px -2735px 15px #bac4d5, 2965px -3035px 15px #8496b4, 3295px -3305px 15px #adb9cd, 3650px -3550px 15px #bac4d5, 3940px -3860px 15px #7e90b0, 4210px -4190px 15px #7e90b0, 4475px -4525px 15px #8798b6, 4775px -4825px 15px #a1aec6;
        }

        .mound {
            margin-top: -80px;
            font-weight: 800;
            font-size: 180px;
            text-align: center;
            color: #dd4040;
            pointer-events: none;
        }

        .mound:before {
            content: "";
            display: block;
            width: 600px;
            height: 200px;
            position: absolute;
            left: 50%;
            margin-left: -300px;
            top: 50px;
            z-index: 1;
            border-radius: 100%;
            background-color: #e8f2f6;
            background-image: linear-gradient(to bottom, #dee8f1, #f6f9fa 60px);
        }

        .mound:after {
            content: "";
            display: block;
            width: 28px;
            height: 6px;
            position: absolute;
            left: 50%;
            margin-left: -150px;
            top: 68px;
            z-index: 2;
            background: #dd4040;
            border-radius: 100%;
            transform: rotate(-15deg);
            box-shadow: -56px 12px 0 1px #dd4040, -126px 6px 0 2px #dd4040, -196px 24px 0 3px #dd4040;
        }

        .mound_text {
            transform: rotate(6deg);
        }

        .mound_spade {
            display: block;
            width: 35px;
            height: 30px;
            position: absolute;
            right: 50%;
            top: 42%;
            margin-right: -250px;
            z-index: 0;
            transform: rotate(35deg);
            background: #dd4040;
        }

        .mound_spade:before,
        .mound_spade:after {
            content: "";
            display: block;
            position: absolute;
        }

        .mound_spade:before {
            width: 40%;
            height: 30px;
            bottom: 98%;
            left: 50%;
            margin-left: -20%;
            background: #dd4040;
        }

        .mound_spade:after {
            width: 100%;
            height: 30px;
            top: -55px;
            left: 0%;
            box-sizing: border-box;
            border: 10px solid #dd4040;
            border-radius: 4px 4px 20px 20px;
        }
    </style>
    <meta charset="UTF-8">
    <title>Pagina No Encontrada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Dosis:400,300,500,800'>
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="content">
        <canvas class="snow" id="snow"></canvas>
        <div class="main-text">
            <h1>Ups!.<br />Esta pagina no existe.</h1><a class="home-link" href="http://eureka.vepagos.com/">Volvamos al
                Principio.</a>
        </div>
        <div class="ground">
            <div class="mound">
                <div class="mound_text">404</div>
                <div class="mound_spade"></div>
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src="./script.js"></script>

</body>

</html>
