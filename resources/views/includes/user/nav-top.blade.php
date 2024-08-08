<nav class="main-menu d-flex navbar navbar-expand-lg">
    <div class="d-flex d-lg-none align-items-end mt-3">
        <ul class="d-flex justify-content-end list-unstyled m-0">
            <li>
                <a href="account.html" class="mx-3">
                    <iconify-icon icon="healthicons:person" class="fs-4"></iconify-icon>
                </a>
            </li>
            <li>
                <a href="wishlist.html" class="mx-3">
                    <iconify-icon icon="mdi:heart" class="fs-4"></iconify-icon>
                </a>
            </li>
            <li>
                <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                    aria-controls="offcanvasCart">
                    <iconify-icon icon="mdi:cart" class="fs-4 position-relative"></iconify-icon>
                    <span class="position-absolute translate-middle badge rounded-circle bg-primary pt-2">03</span>
                </a>
            </li>
            <li>
                <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"
                    aria-controls="offcanvasSearch">
                    <iconify-icon icon="tabler:search" class="fs-4"></iconify-icon>
                </a>
            </li>
        </ul>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body justify-content-between">
            <select class="filter-categories border-0 mb-0 me-5">
                <option>Shop by Category</option>
                <option>Clothes</option>
                <option>Food</option>
                <option>Toy</option>
            </select>

            <ul class="navbar-nav menu-list list-unstyled d-flex gap-md-3 mb-0">
                <li class="nav-item">
                    <a href="index.html" class="nav-link active">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" id="pages" data-bs-toggle="dropdown"
                        aria-expanded="false">Pages</a>
                    <ul class="dropdown-menu" aria-labelledby="pages">
                        <!-- Dropdown items here -->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="shop.html" class="nav-link">Shop</a>
                </li>
                <li class="nav-item">
                    <a href="blog.html" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="contact.html" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Others</a>
                </li>
                <li class="nav-item">
                    <a href="https://templatesjungle.gumroad.com/l/waggy-pet-shop-ecommerce-html-website-template"
                        class="nav-link fw-bold text-dark" target="_blank">GET PRO</a>
                </li>
            </ul>

            <div class="d-none d-lg-flex align-items-end">
                <ul class="d-flex justify-content-end list-unstyled m-0">
                    @if (Route::has('login'))
                        <nav class="d-flex justify-content-end">
                            @auth
                                <li>
                                    <a href="#"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Welcome! <b>{{ Auth::check() ? Auth::user()->name : '' }}</b>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Log
                                        in</a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Register</a>
                                    </li>
                                @endif
                            @endauth
                        </nav>
                    @endif
                    <li>
                        <a href="account.html" class="mx-3">
                            <iconify-icon icon="healthicons:person" class="fs-4"></iconify-icon>
                        </a>
                    </li>
                    <li>
                        <a href="wishlist.html" class="mx-3">
                            <iconify-icon icon="mdi:heart" class="fs-4"></iconify-icon>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                            aria-controls="offcanvasCart">
                            <iconify-icon icon="mdi:cart" class="fs-4 position-relative"></iconify-icon>
                            <span
                                class="position-absolute translate-middle badge rounded-circle bg-primary pt-2">03</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</nav>
