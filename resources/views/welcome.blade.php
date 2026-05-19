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
                {{-- usage --}}
                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <x-button color="gray" shade="200" outline class="flex gap-2 items-center py-1 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-[1em]" fill="currentColor"
                                class="bi bi-globe" viewBox="0 0 16 16">
                                <path
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                            </svg>
                            EN
                        </x-button>
                    </x-slot>
                    <a href="#" class="block rounded-xl px-4 py-2 text-sm hover:bg-zinc-700">
                        🇺🇸 English
                    </a>

                    <a href="#" class="block rounded-xl px-4 py-2 text-sm hover:bg-zinc-700">
                        🇲🇽 Español
                    </a>
                </x-dropdown>

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

            <x-welcome.card-apply modalid="modal-apply-student">
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
            <x-welcome.card-apply modalid="modal-apply-researcher">
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

            <x-welcome.card-apply modalid="modal-apply-industry">
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



    <x-modal id="modal-apply-student" title="Apply as student">
        <form class="flex flex-wrap gap-4" id="form-apply-student">
            <!-- 🧩 Section 1 -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Background & Motivation
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What is your current academic program and institution?</label>
                <input type="text" name="program" class="border rounded-md px-3 py-2 text-slate-800" required />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Why are you interested in combining gastronomy and artificial
                    intelligence?</label>
                <textarea name="motivation" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Which of the following best describes your goal?</label>
                <select name="goal" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="">Select an option...</option>
                    <option>Work in industry (AI/tech)</option>
                    <option>Academic research</option>
                    <option>Entrepreneurship</option>
                    <option>Culinary innovation</option>
                </select>
            </div>
            <!-- 🧠 Section 2 -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Technical Foundations
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Rate your level in programming</label>

                <select name="programming_level" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="1">1 — No experience</option>
                    <option value="2">2 — Basic understanding (tutorials)</option>
                    <option value="3">3 — Can build simple projects</option>
                    <option value="4">4 — Comfortable building real apps</option>
                    <option value="5">5 — Advanced / production experience</option>
                </select>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Have you worked with any of the following?</label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="tech[]" value="none" />
                    None
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="tech[]" value="cv" />
                    Computer Vision
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="tech[]" value="ml" />
                    Machine Learning
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="tech[]" value="data" />
                    Data Analysis
                </label>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Describe a project where you solved a problem using data or technology</label>
                <textarea name="project" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>
            <!-- 🍳 Section 3 -->
            <h2 class="text-lg font-semibold mt-4 w-full">Culinary + Applied Thinking</h2>

            <div class="flex flex-col  gap-2 w-full">
                <label class="text-sm">How would you use computer vision to improve a professional kitchen?</label>
                <textarea name="cv_kitchen" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>
            <div class="flex flex-col  gap-2 w-full">
                <label class="text-sm">Identify one inefficiency in a kitchen and propose a technological
                    solution</label>
                <textarea name="efficiency" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>
            <!-- 🚀 Section 4 -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Commitment & Fit
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">How many hours per week can you dedicate?</label>
                <select name="hours" class="border rounded-md px-3 py-2 text-slate-800 text-slate-800" required>
                    <option value="">Select an option...</option>
                    <option>5–10</option>
                    <option>10–20</option>
                    <option>20–40</option>
                    <option>40+</option>
                </select>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Are you interested in</label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="research" />
                    Research publication
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="nvidia" />
                    NVIDIA certifications
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="deployment" />
                    Real-world deployment
                </label>
            </div>
            <div class="flex flex-col  gap-2 w-full">
                <label class="text-sm">Why should we select you over other candidates?</label>
                <textarea name="why_you" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>
        </form>


        <x-slot name="footer">
            <div class="flex gap-4 justify-end">
                <x-button color="slate" class="close-modal">
                    Back
                </x-button>
                <x-button type="submit" form="form-apply-student">
                    Submit
                </x-button>
            </div>
        </x-slot>
    </x-modal>



    <x-modal id="modal-apply-researcher" title="Apply as researcher">
        <form class="flex flex-wrap gap-4" id="form-apply-researcher">

            <!-- 🧩 Section 1: Academic Profile -->
            <h2 class="text-lg font-semibold w-full flex items-center gap-3">
                Academic Profile <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Current affiliation and highest degree</label>
                <input type="text" name="affiliation_degree" class="border rounded-md px-3 py-2 text-slate-800"
                    required />
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">List your top 3 publications</label>
                <textarea name="publications" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Have you published in indexed journals or conferences?</label>

                <div class="flex flex-col gap-2">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="indexed_publications" value="q1" required />
                        Q1 Journals
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="indexed_publications" value="tier1" />
                        Tier-1 conferences (CVPR, CHI, NeurIPS)
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="indexed_publications" value="regional" />
                        Regional journals
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="indexed_publications" value="none" />
                        No publications
                    </label>
                </div>
            </div>

            <!-- 🧠 Section 2: Technical Depth -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">Technical Depth<div
                    class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Describe your experience with computer vision architectures</label>
                <textarea name="cv_experience" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Which frameworks have you used?</label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="frameworks[]" value="pytorch" />
                    PyTorch
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="frameworks[]" value="tensorflow" />
                    TensorFlow
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="frameworks[]" value="opencv" />
                    OpenCV
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="frameworks[]" value="custom" />
                    Custom pipelines
                </label>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Explain how you would design a model for real-time kitchen monitoring</label>
                <textarea name="kitchen_model_design" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <!-- 🔬 Section 3: Research Thinking -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Research Thinking
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What is a key research gap in computer vision for kitchens?</label>
                <textarea name="research_gap" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">How would you design a dataset for kitchen environments?</label>
                <textarea name="dataset_design" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Discuss trade-offs between accuracy and latency in real-time systems</label>
                <textarea name="tradeoffs" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <!-- ⚙️ Section 4: Applied Deployment -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Applied Deployment
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Describe a project where you deployed a model in a real-world environment</label>
                <textarea name="deployment_project" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Experience with IoT or sensor fusion?</label>
                <div class="flex gap-2 w-full">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="iotsensor_experience[]" value="iot" />
                        IoT
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="iotsensor_experience[]" value="sensorfusion" />
                        Sensor fusion
                    </label>
                </div>
                <textarea name="iotsensor_experience" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    placeholder="Explain..." required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">How would you integrate computer vision with kitchen hardware systems?</label>
                <textarea name="cv_hardware_integration"
                    class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800" required></textarea>
            </div>

            <!-- 🧭 Section 5: Vision & Alignment -->

            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Vision & Alignment
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What research line would you develop in this lab?</label>
                <textarea name="research_line" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">How would you target a CVPR/CHI publication from your work?</label>
                <textarea name="publication_strategy" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What impact do you want your research to generate?</label>
                <textarea name="impact" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <!-- 🔥 Section 6: Execution Capability -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Execution Capability
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Availability (full-time / part-time)</label>
                <select name="availability" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="">Select an option...</option>
                    <option value="full-time">full-time</option>
                    <option value="part-time">part-time</option>
                </select>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Experience leading teams?</label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="team_leadership" value="yes" required />
                    Yes
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="team_leadership" value="no" />
                    No
                </label>

                <textarea name="team_leadership_explanation"
                    class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800" placeholder="explain..."
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Describe your ideal research project in this lab</label>
                <textarea name="ideal_project" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

        </form>
    </x-modal>


    <x-modal id="modal-apply-industry" title="Apply as industry partner">
        <form class="flex flex-wrap gap-4" id="form-apply-industry">

            <!-- 🧩 Section 1: Company Profile -->
            <h2 class="text-lg font-semibold w-full flex items-center gap-3">
                Company Profile
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Company name, industry, and size</label>
                <input type="text" name="company_profile" class="border rounded-md px-3 py-2 text-slate-800" required />
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Do you operate in food, hospitality, or tech?</label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="industries[]" value="food" />
                    Food
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="industries[]" value="hospitality" />
                    Hospitality
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="industries[]" value="tech" />
                    Tech
                </label>
            </div>

            <!-- 💼 Section 2: Use Case Identification -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Use Case Identification
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What problem are you trying to solve?</label>
                <textarea name="problem" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Which areas are relevant?</label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="areas[]" value="quality" />
                    Food quality control
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="areas[]" value="hygiene" />
                    Hygiene monitoring
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="areas[]" value="automation" />
                    Automation
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="areas[]" value="customer_experience" />
                    Customer experience
                </label>
            </div>

            <!-- 📊 Section 3: Data & Infrastructure -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Data & Infrastructure
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Do you currently collect visual data?</label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="visual_data" value="yes" required />
                    Yes
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="visual_data" value="no" />
                    No
                </label>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What type?</label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="data_types[]" value="cameras" />
                    Cameras
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="data_types[]" value="sensors" />
                    Sensors
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="data_types[]" value="pos" />
                    POS systems
                </label>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Estimated volume of data</label>

                <select name="data_volume" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="">Select an option...</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <!-- ⚙️ Section 4: Technical Readiness -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Technical Readiness
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Do you have an internal tech team?</label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="tech_team" value="yes" required />
                    Yes
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="tech_team" value="no" />
                    No
                </label>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Experience with AI?</label>

                <select name="ai_experience" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- 🚀 Section 5: Business & ROI -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Business & ROI
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">What would success look like in 6 months?</label>
                <textarea name="success_6months" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Budget range</label>

                <select name="budget_range" class="border rounded-md px-3 py-2 text-slate-800">
                    <option value="">Select an option...</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Interest in:</label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="pilot" />
                    Pilot program
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="custom_model" />
                    Custom AI model
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="interests[]" value="licensing" />
                    Licensing
                </label>
            </div>

            <!-- 🤝 Section 6: Strategic Fit -->
            <h2 class="text-lg font-semibold mt-4 w-full flex items-center gap-3">
                Strategic Fit
                <div class="flex-1 border-t border-gray-200"></div>
            </h2>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Why do you want to partner with this lab?</label>
                <textarea name="partnership_reason" class="border rounded-md px-3 py-2 min-h-[2.5em] text-slate-800"
                    required></textarea>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <label class="text-sm">Timeline expectations</label>

                <select name="timeline_expectations" class="border rounded-md px-3 py-2 text-slate-800" required>
                    <option value="">Select an option...</option>
                    <option value="immediate">Immediate</option>
                    <option value="1_3_months">1–3 months</option>
                    <option value="3_6_months">3–6 months</option>
                    <option value="6plus_months">6+ months</option>
                </select>
            </div>

        </form>
    </x-modal>


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

    <script>
        document.addEventListener('click', e => {
            const dropdowns = document.querySelectorAll('[data-dropdown]');

            dropdowns.forEach(dropdown => {
                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');

                if (trigger.contains(e.target)) {
                    const isOpen = !menu.classList.contains('hidden');

                    dropdowns.forEach(d => {
                        d.querySelector('[data-dropdown-menu]')
                            ?.classList.add('hidden');
                    });

                    if (!isOpen) {
                        menu.classList.remove('hidden');
                    }

                    return;
                }

                if (!dropdown.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>