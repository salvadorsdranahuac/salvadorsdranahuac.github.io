@props([
    'id',
    'title' => null,
    'closable' => true,
    'full' => false,
])

@php
    $closable = filter_var($closable, FILTER_VALIDATE_BOOL); // normalize
@endphp

<div id="{{ $id }}"
     data-closable="{{ $closable ? '1' : '0' }}"
     class="fixed inset-0 z-[60] hidden opacity-0 pointer-events-none transition-opacity duration-300 flex flex-col justify-center items-center">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop"></div>

    <!-- Modal box -->
    <div class="relative bg-zinc-800 text-[var(--text)] rounded-lg shadow-lg mx-auto w-full max-w-[min(calc(100vw-1.5rem),100ch)] flex flex-col 
    {{ $full ? 'flex-1' : '' }} max-h-[calc(100%-min(5rem,5vh))] p-6 scale-95 transition-opacity transition-transform duration-300 modal-box">

        <div class="flex w-[calc(100%+3rem)] px-6 justify-between border-b border-gray-600 -mx-6">
            @if($title)
                <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
            @endif
 
                <button type="button"
                    class="ml-auto size-[1.5rem] font-light text-neutral-500 hover:text-neutral-800 text-[1.5rem]/none close-modal {{ $closable ? '' : 'disabled' }}">
                    &times;
                </button> 
        </div>

        <div class="flex-1 min-h-0 overflow-auto px-4 py-4">
            {{ $slot }}
        </div>

        <div class="border-t my-4 border-gray-600"></div>
            @isset($footer)
                {{ $footer }}
            @else
                <x-button color="orange" class="close-modal self-end {{ $closable ? '' : 'disabled' }}">
                    Cerrar
                </x-button>
            @endisset
    </div>
</div>

@once
    <script>
        class ModalController {
            constructor() {
                this.activeModal = null;

                document.addEventListener("keydown", (e) => {
                    if (e.key === "Escape" && this.activeModal) {
                        if (this.activeModal.dataset.closable === "1") {
                            this.close(this.activeModal.id);
                        }
                    }
                });
            }

            open(id) {
                const modal = document.getElementById(id);
                if (!modal) return;

                this.activeModal = modal;

                modal.classList.remove("hidden", "pointer-events-none");
                document.body.classList.add("overflow-hidden");

                requestAnimationFrame(() => {
                    modal.classList.remove("opacity-0");
                    modal.querySelector(".modal-box").classList.remove("scale-95");
                });
            }

            close(id) {
                const modal = document.getElementById(id);
                if (!modal || modal.dataset.closable !== "1") return;

                modal.classList.add("opacity-0");
                modal.querySelector(".modal-box").classList.add("scale-95");

                setTimeout(() => {
                    modal.classList.add("hidden", "pointer-events-none");
                    document.body.classList.remove("overflow-hidden");
                }, 300);

                this.activeModal = null;
            }

            toggle(id) {
                const modal = document.getElementById(id);
                if (modal.classList.contains("hidden")) this.open(id);
                else this.close(id);
            }

            setClosable(id, closable) {
                const modal = document.getElementById(id);
                if (!modal) return;

                modal.dataset.closable = closable ? "1" : "0";

                modal.querySelectorAll(".close-modal").forEach(btn => {
                    if (closable) {
                        btn.classList.remove("disabled", "opacity-50", "pointer-events-none");
                    } else {
                        btn.classList.add("disabled", "opacity-50", "pointer-events-none");
                    }
                });
            }

        }

        window.Modal = new ModalController();

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".close-modal").forEach(btn => {
                btn.addEventListener("click", () => {
                    const modal = btn.closest("[id]");
                    Modal.close(modal.id);
                });
            });

            document.querySelectorAll("[id] > .backdrop").forEach(backdrop => {
                backdrop.addEventListener("click", () => {
                    const modal = backdrop.parentElement;
                    if (modal.dataset.closable === "1") {
                        Modal.close(modal.id);
                    }
                });
            });
        });

        function openModal(id) {
            requestAnimationFrame(() => {
                Modal.open(id);
            });
        }

        function closeModal(id) {
            requestAnimationFrame(() => {
                Modal.close(id);
            });
        }
    </script>
@endonce
