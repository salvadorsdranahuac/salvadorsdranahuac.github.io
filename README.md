<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GastroVision Lab</title>

    @fonts
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@300;400;500;600;700&display=swap');
        
        html {
            scroll-behavior: smooth;
        }


        :root {
            --bg: #FDFDFC;
            --text: #1b1b18;
        }

        .dark {
            --bg: #1b1b18;
            --text: white;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .gradient {
            background-blend-mode: hard-light;
            background-image: linear-gradient(to right, rgb(217 70 239 / 40%), rgb(253 224 71 / 40%));
        }

        .scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;

            &::-webkit-scrollbar {
                display: none;
            }
        }


        .gradient-mask {
            background: linear-gradient(to right, #F5F3FF calc(50vw - 10rem), #FE5900 calc(50vw + 10rem));
            background-attachment: fixed;

            -webkit-mask-image: var(--mask-image);
            -webkit-mask-repeat: no-repeat;
            -webkit-mask-position: center;
            -webkit-mask-size: contain;

            mask-image: var(--mask-image);
            mask-repeat: no-repeat;
            mask-position: center;
            mask-size: contain;
        }

        #research .card-black img {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<body class="bg-[var(--bg)] text-[var(--text)] min-h-screen">
    <nav
        class="sticky top-0 z-50 w-screen border-gray-200 bg-[var(--bg)] dark:border-gray-700 flex h-16 justify-between gap-4 pr-4 sm:pr-6 lg:pr-8">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-center bg-orange-500 py-3 px-6">
            <img class="w-full h-full object-cover" src="{{ asset('img/logo_anahuacqueretaro.svg') }}">
        </div>


        <!-- Links -->
        <div class="hidden ml-auto lg:flex  text-gray-700 dark:text-gray-200 text-md font-medium">
            <a href="#about" class="flex items-center p-3 transition hover:text-orange-500">
                What we do
            </a>

            <a href="#research" class="flex items-center p-3 transition hover:text-orange-500">
                Research areas
            </a>

            <a href="#projects" class="flex items-center p-3 transition hover:text-orange-500">
                Projects
            </a>

            <a href="#opportunities" class="flex items-center p-3 transition hover:text-orange-500">
                Opportunities
            </a>

            <div class="flex items-center gap-3 ml-4">
                <x-button color="gray" shade="200" outline>
                    Login
                </x-button>

                <x-button>
                    Sign up
                </x-button>
            </div>
        </div>

        <!-- Hamburger -->
        <button id="menuBtn"
            class="flex items-center justify-center self-center rounded-lg p-2 dark:hover:bg-gray-700 hover:bg-gray-100 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

    </nav>

    {{--
    <div class="relative h-[calc(100vh-4rem)] overflow-hidden">
        <div class="absolute w-full h-full overflow-y-auto">
        </div>
    </div>
    --}}

    <section class="relative bg-pink-300 h-[calc(100vh-4rem)] flex flex-center text-center">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('video/epickitchens.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/30" style="background-image: url('{{ asset('img/grid_neg.png') }}')">
        </div>


        <div
            class="relative z-10 flex flex-col justify-between items-center gap-6 w-full h-[calc(100%-12rem)] mb-[6rem] px-[max(2rem,6vw)]">
            <img class="h-20 object-cover" src="{{ asset('img/logo_anahuacqro_classic.svg') }}">

            <div class="text-5xl lg:text-6xl font-['Zilla_Slab'] mb-4 font-semibold">
                Engineering the future of culinary training and performance with computer vision
            </div>

            <div class="flex flex-col flex-wrap sm:flex-row gap-x-12 gap-y-4 text-3xl justify-center">
                <x-button class="w-72 rounded-full font-light gradient p-3">Join the lab</x-button>
                <x-button class="w-72 rounded-full font-light p-3" color="slate" shade="100">Explore
                    research</x-button>
            </div>
        </div>
    </section>

    <section class="min-h-screen py-9 flex-center flex-col pt-[5rem]" id="about">
        <div class="flex flex-col items-center justify-center gap-9 max-w-full">
            <div class="text-center text-2xl px-[5%] md:px-[20%]">
                <div class="text-[2em] font-['Zilla_Slab'] font-extrabold mb-4 ">Transforming Precision.</div>
                We develop state-of-the-art computer vision systems to augment human capability in professional
                kitchens
                and educational institutions.
            </div>

            <div class="flex  text-violet-50 text-lg
                    max-w-full overflow-x-scroll gap-5 px-[12.5%] center-scroll scrollbar-hidden

                    {{--
                    justify-center flex-col md:flex-row gap-y-[1rem] gap-x-[2.5%] px-[20%] md:px-[5%]
                    --}}
                       ">
                <x-welcome.card-feature image="https://placehold.co/309x351" class="min-w-[min(30rem,75vw)]">
                    Real-time tracking of uniforms, sanitization protocols, cross-contamination prevention.
                </x-welcome.card-feature>

                <x-welcome.card-feature image="https://placehold.co/309x351" class="min-w-[min(30rem,75vw)]">
                    Spectral and visual analysis of ingredients and plating to ensure absolute consistency.
                </x-welcome.card-feature>

                <x-welcome.card-feature image="https://placehold.co/309x351" class="min-w-[min(30rem,75vw)]">
                    Kinematic tracking of culinary techniques, knife skills, and timing across complex recipes.
                </x-welcome.card-feature>
            </div>
        </div>
    </section>

    <section class="min-h-screen py-9 flex-center flex-col bg-gradient-to-b from-transparent to-[#281C3E] pt-[5rem]"
        id="research">
        <div class="flex flex-col items-center justify-center px-[5%] gap-4 max-w-full">


            <div class="text-[2em] font-['Zilla_Slab'] font-extrabold">
                Real world applications across the entire gastronomic process
            </div>
            This synthesis analyzes the evolution toward deep learning and hybrid models, highlighting
            advanced
            hardware
            integration and the importance of ethics in professional kitchens.

            <div class="text-[2em] font-['Zilla_Slab'] font-extrabold">Tech trends & Applications</div>
            <div class="flex gap-4 flex-col lg:flex-row">
                <x-welcome.card-black img="{{ asset('img/prep.png') }}">
                    <x-slot:title>
                        Prep (Mise en place)
                    </x-slot:title>
                    Models like YOLO and Vision Transformers optimize the detection of ingredients.
                </x-welcome.card-black>

                <x-welcome.card-black img="{{ asset('img/cooking.png') }}">
                    <x-slot:title>
                        Line cooking
                    </x-slot:title>
                    Integration of LiDAR and tRGB improve real-time perception in high-stress autonomous
                    kitchens
                </x-welcome.card-black>

                <x-welcome.card-black img="{{ asset('img/plating.png') }}">
                    <x-slot:title>
                        Plating & QA
                    </x-slot:title>
                    Tools like Grad-CAM validate recipe executions and automated quality assessments.
                </x-welcome.card-black>
            </div>

            <div class="text-[2em] font-['Zilla_Slab'] font-extrabold">Ethics & privacy</div>
            <div class="flex gap-4 flex-col lg:flex-row">
                <x-welcome.card-black img="{{ asset('img/privacy.png') }}">
                    <x-slot:title>
                        Privacy via Federated Learning
                    </x-slot:title>
                    Collaborative network training without sharing proprietary restaurant data, techniques, or
                    secret recipes.
                </x-welcome.card-black>

                <x-welcome.card-black img="{{ asset('img/ip.png') }}">
                    <x-slot:title>
                        Strict protocols for IP
                    </x-slot:title>
                    Networked collaborative models with strict protocols to protect intellectual property in
                    high-end gastronomy.
                </x-welcome.card-black>

                <x-welcome.card-black img="{{ asset('img/model.png') }}">
                    <x-slot:title>
                        Unified Generative Models
                    </x-slot:title>
                    Evolution towards multimodal architectures bridging explicit culinary rules with generative
                    AI for operational robustness.
                </x-welcome.card-black>
            </div>

        </div>
    </section>

    <section class="min-h-screen py-9 bg-zinc-800 flex-center flex-col pt-[5rem]" id="projects">
        <div class="flex flex-col items-center justify-center gap-4 max-w-full">
            <div class="flex flex-col items-center px-6 gap-4">
                <div class="text-[2em] font-['Zilla_Slab'] font-extrabold">
                    Applied Research
                </div>
                <div class="font-['Zilla_Slab'] text-xl">
                    Bridging the gap between empirical gastronomy and computational perception to scale
                    world-class
                    culinary
                    education globally.
                </div>

                <div class="flex gap-5 flex-wrap justify-center">
                    <div class="flex gap-5">
                        <div class="flex-1 flex flex-col items-center gap-2 text-xl">
                            <div class="size-28 gradient-mask" style="--mask-image: url('{{ asset('img/eye.png') }}')">
                            </div>
                            Input
                        </div>

                        <div class="flex-1 flex flex-col items-center gap-2 text-xl">
                            <div class="size-28 gradient-mask"
                                style="--mask-image: url('{{ asset('img/braain.png') }}')"></div>
                            Model
                        </div>
                    </div>
                    <div class="flex gap-5">

                        <div class="flex-1 flex flex-col items-center gap-2 text-xl">
                            <div class="size-28 gradient-mask"
                                style="--mask-image: url('{{ asset('img/insightengine.png') }}')"></div>
                            Insight
                        </div>

                        <div class="flex-1 flex flex-col items-center gap-2 text-xl">
                            <div class="size-28 gradient-mask" style="--mask-image: url('{{ asset('img/hand.png') }}')">
                            </div>
                            Action
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-full overflow-x-scroll flex gap-5 px-[12.5%] center-scroll scrollbar-hidden">
                <x-welcome.card-black class="min-w-[min(40rem,75vw)]  items-start">
                    <x-slot:title>
                        AI-Powered Uniform Compliance System
                    </x-slot:title>
                    <div class="mb-2 text-base">
                        Digitizes subjective culinary grading into objective quantitative metrics by mapping
                        student
                        plating against baseline master chef executions.
                    </div>

                    <div class="flex gap-4 mb-2 text-base">
                        <div>
                            How It Works
                            <ul class="list-disc pl-6">
                                <li>
                                    Data: Edge-device video feeds via a QR deployment application.
                                </li>
                                <li>
                                    Model: Object detection architecture following CRISP-DM methodology.
                                </li>
                                <li>
                                    Output: Real-time alerts identifying hat, jacket, apron, and pants.
                                </li>
                            </ul>
                        </div>

                        <div>
                            Value Generated
                            <ul class="list-disc pl-6">
                                <li>
                                    Drastic reduction of manual oversight and inspection time.
                                </li>
                                <li>
                                    Unbiased operational standardization in hygiene safety.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-base">
                        Scientific Evidence: Validated in field tests achieving ~85–86% precision across diverse
                        culinary uniform items (Castillo-Ortiz et al., 2024a).
                    </div>
                </x-welcome.card-black>

                <x-welcome.card-black class="min-w-[min(40rem,75vw)]  items-start">
                    <x-slot:title>
                        Culinary Skill Transfer Intelligence Engine
                    </x-slot:title>
                    <div class="mb-2 text-base">
                        Digitizes subjective culinary grading into objective quantitative metrics by mapping
                        student plating against baseline master chef executions.
                    </div>

                    <div class="flex gap-4 mb-2 text-base">
                        <div>
                            How It Works
                            <ul class="list-disc pl-6">
                                <li>
                                    Data: High-resolution standardized plating imagery.
                                <li>
                                    Model: VGG-16 Deep Convolutional Neural Networks (CNNs).
                                </li>
                                <li>
                                    Output: Euclidean distance, cosine similarity, and perceptual loss scores.
                                </li>
                            </ul>
                        </div>

                        <div>
                            Value Generated
                            <ul class="list-disc pl-6">
                                <li>
                                    Objective, quantifiable evaluation of culinary performance.
                                </li>
                                <li>
                                    Global scalability for culinary education.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-base">
                        Scientific Evidence: Validated in field tests achieving ~85–86% precision across diverse
                        culinary uniform items (Castillo-Ortiz et al., 2024a).
                    </div>
                </x-welcome.card-black>
                <x-welcome.card-black class="min-w-[min(40rem,75vw)]  items-start">
                    <x-slot:title>
                        Smart Kitchen Vision Systems
                    </x-slot:title>
                    <div class="mb-2 text-base">
                        Scientific Evidence: An integrated spatial computing network that monitors, anticipates,
                        and orchestrates the
                        professional kitchen floor.
                    </div>

                    <div class="flex gap-4 mb-2 text-base">
                        <div>
                            How It Works
                            <ul class="list-disc pl-6">
                                <li>
                                    Data: Multimodal inputs from IoT edge nodes and optical sensors.
                                <li>
                                    Model: Fused object detection and semantic segmentation pipelines.
                                </li>
                                <li>
                                    Output: Centralized dashboard for kitchen automation & safety.
                                </li>
                            </ul>
                        </div>

                        <div>
                            Value Generated
                            <ul class="list-disc pl-6">
                                <li>
                                    Frictionless automation of standard back-of-house processes.
                                </li>
                                <li>
                                    Industrial scalability from educational labs to enterprise hospitality.
                                </li>
                            </ul>


                        </div>
                    </div>

                    <div class="text-base">
                        Scientific Evidence: Integrates the foundations of uniform compliance (Castillo-Ortiz et
                        al., 2024a) and
                        quality evaluation (Castillo-Ortiz et al., 2024b) into a unified ambient operating
                        system.
                    </div>
                </x-welcome.card-black>
            </div>

            <x-button class="text-2xl font-light rounded-full p-2 px-6 gradient">
                Browse all projects
            </x-button>


        </div>
    </section>

    <section id="opportunities"
        class="min-h-screen py-9 px-[max(2rem,5%)] bg-zinc-900 flex-center flex-col text-center bg-gradient-to-b from-[#ff590044] to-[#ff590088] pt-[5rem]">

        <div class="text-5xl font-['Zilla_Slab'] font-extrabold mb-4 ">Join the frontier</div>

        <div class="text-3xl mb-4 font-light">
            We are actively seeking brilliant minds to help build the future of gastronomy.
        </div>

        <div class="flex gap-4 flex-col md:flex-row">

            <x-welcome.card-apply href="/apply-student">
                <x-slot:title>
                    Students
                </x-slot:title>

                Undergraduate and postgraduate positions for those passionate about integrating ML with culinary
                arts.

                <ul class="mt-4 list-disc pl-5">
                    <li>NVIDIA certifications & training</li>
                    <li>Real-world AI deployment pipeline</li>
                    <li>Thesis supervision</li>
                </ul>

                <x-slot:button>
                    Apply as student
                </x-slot:button>
            </x-welcome.card-apply>
            <x-welcome.card-apply href="/positions">
                <x-slot:title>
                    Researchers
                </x-slot:title>

                Post-docs and PhD candidates driving novel computer vision architectures in unconstrained
                environments.

                <ul class="mt-4 list-disc pl-5">
                    <li>Compute cluster access (A100s)</li>
                    <li>Conference publications (CVPR, CHI)</li>
                    <li>Prototyping budget</li>
                </ul>

                <x-slot:button>
                    View open positions
                </x-slot:button>
            </x-welcome.card-apply>

            <x-welcome.card-apply href="/partners">
                <x-slot:title>
                    Industry Partners
                </x-slot:title>

                Culinary institutions, ghost kitchens, and tech giants looking to deploy our systems or
                collaborate.

                <ul class="mt-4 list-disc pl-5">
                    <li>Pilot program integration</li>
                    <li>Custom model tuning</li>
                    <li>Licensing opportunities</li>
                </ul>

                <x-slot:button>
                    Partner with us
                </x-slot:button>
            </x-welcome.card-apply>

        </div>



    </section>

    <footer class="bg-neutral-900 px-14 pt-16 pb-14 text-violet-50">
        <div class="flex flex-col gap-8">

            <div class="flex flex-col gap-12 lg:flex-row lg:justify-between">

                <!-- Brand -->
                <div class="max-w-md">
                    <h2 class="text-2xl leading-8">
                        🟩 GastroVision Lab
                    </h2>

                    <p class="mt-2 text-base leading-6 text-violet-50/60">
                        Engineering the future of culinary training with computer vision.
                    </p>
                </div>

                <!-- Links -->
                <div class="flex flex-wrap gap-14">



                    <div class="flex w-48 flex-col gap-4">
                        <h3 class="text-2xl font-semibold leading-8">
                            Explore
                        </h3>

                        <a class="text-2xl leading-8 text-violet-50/60" href="#about">
                            What we do
                        </a>

                        <a class="text-2xl leading-8 text-violet-50/60" href="#research">
                            Research
                        </a>

                        <a class="text-2xl leading-8 text-violet-50/60" href="#projects">
                            Projects
                        </a>
                    </div>

                </div>
            </div>

            <p class="text-lg leading-8">
                © 2026 GastroVision Lab. All rights reserved.
            </p>

        </div>
    </footer>






    <script>
        const centerScroll = () => {
            document.querySelectorAll('.center-scroll').forEach(el => {
                el.scrollLeft = (el.scrollWidth - el.clientWidth) / 2;
                el.scrollTop = (el.scrollHeight - el.clientHeight) / 2;
            });
        };

        centerScroll();

        window.addEventListener('resize', centerScroll);

        if (window.matchMedia('(pointer:fine)').matches) {
            document.querySelectorAll('.scrollbar-hidden').forEach(el => {
                let isDown = false;

                let startX;
                let startY;

                let scrollLeft;
                let scrollTop;

                let velocityX = 0;
                let velocityY = 0;

                let lastX;
                let lastY;
                let momentum;

                const friction = 0.95;

                el.addEventListener('mousedown', e => {
                    isDown = true;

                    startX = e.pageX;
                    startY = e.pageY;

                    lastX = e.pageX;
                    lastY = e.pageY;

                    scrollLeft = el.scrollLeft;
                    scrollTop = el.scrollTop;

                    cancelAnimationFrame(momentum);

                    el.style.cursor = 'grabbing';
                    el.style.userSelect = 'none';
                });

                window.addEventListener('mouseup', () => {
                    if (!isDown) return;

                    isDown = false;

                    el.style.cursor = '';
                    el.style.userSelect = '';

                    const animate = () => {
                        velocityX *= friction;
                        velocityY *= friction;

                        el.scrollLeft -= velocityX;
                        el.scrollTop -= velocityY;

                        if (
                            Math.abs(velocityX) > 0.1 ||
                            Math.abs(velocityY) > 0.1
                        ) {
                            momentum = requestAnimationFrame(animate);
                        }
                    };

                    animate();
                });

                el.addEventListener('mousemove', e => {
                    if (!isDown) return;

                    e.preventDefault();

                    const dx = e.pageX - startX;
                    const dy = e.pageY - startY;

                    velocityX = e.pageX - lastX;
                    velocityY = e.pageY - lastY;

                    lastX = e.pageX;
                    lastY = e.pageY;

                    el.scrollLeft = scrollLeft - dx;
                    el.scrollTop = scrollTop - dy;
                });
            });
        }





    </script>
</body>

</html>