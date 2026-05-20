@props([
    'id' => 'drawer_'.uniqid(),
    'direction' => 'right'
])

<div class="drawer-wrapper">
    <div id="{{ $id }}" {{ $attributes->merge([ 'class' => 'drawer ' . $direction, ]) }}>   
        <div class="d-flex align-items-center gap-2 zilla fs-3 pl-3 pr-1 py-2 border-bottom">
            {{ $title ?? null}}
            <div class="flex-1 align-self-start">
                <a href="javascript:void(0)" class="closebtn" onclick="closeDrawer()">
                    &times;
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-auto px-3" style="scrollbar-gutter: stable;">
            {{ $slot }}
        </div>

        <div class="px-3 pb-3 border-top">
            {{ $footer ?? null}}
        </div>
    </div>
</div>


@once
    <script>
        function lockBodyScroll(locked) {
            const body = document.body;

            if (locked) {
                if (body.classList.contains('overflow-hidden')) return;

                const scrollbarWidth =
                    window.innerWidth - document.documentElement.clientWidth;

                body.classList.add('overflow-hidden');
                body.style.paddingRight = scrollbarWidth + 'px';
            } else {
                body.classList.remove('overflow-hidden');
                body.style.paddingRight = '';
            }
        }

        function openDrawer(id) {
            const drawer = document.getElementById(id);
            drawer?.classList.add('drawer-open');
            lockBodyScroll(true);
        }

        function closeDrawer(id = null) {
            const drawers = id
                ? [document.getElementById(id)]
                : document.querySelectorAll('.drawer-open');

            drawers.forEach(drawer => {
                drawer?.classList.remove('drawer-open');
            });

            if (!document.querySelector('.drawer-open')) {
                lockBodyScroll(false);
            }
        }

        document.addEventListener('mousedown', function (e) {
            if (e.target.closest('.modal.show')) return;

            if (e.target.closest('.swal2-container')) return;

            const drawer = document.querySelector('.drawer-open');

            if (!drawer) return;

            if (!drawer.contains(e.target)) {
                drawer.classList.remove('drawer-open');
                lockBodyScroll(false);
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                document
                    .querySelectorAll('.drawer-open')
                    .forEach(el => el.classList.remove('drawer-open'));

                lockBodyScroll(false);
            }
        });
    </script>
@endonce