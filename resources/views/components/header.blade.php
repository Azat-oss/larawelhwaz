<!-- resources/views/components/header.blade.php -->
<style>
    
    /* Стили для header - темная тема как в основном layout */
    .header {
        background: #1a202c;
        padding: 12px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Логотип */
    .header-logo {
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        flex: 0 0 auto;
    }

    .header-logo:hover {
        color: #63b3ed;
    }

    .header-logo i {
        color: #63b3ed;
        font-size: 28px;
    }

    .header-logo__img {
        width: 40px;
        height: 40px;
        background: #0d6efd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
    }

    .header-logo__text {
        font-size: 24px;
        font-weight: 700;
        color: #63b3ed;
    }

    /* Поиск */
    .header-search {
        flex: 1;
        max-width: 500px;
        position: relative;
        min-width: 200px;
    }

    .header-search__form {
        display: flex;
        position: relative;
        width: 100%;
    }

    .header-search__wrapper {
        display: flex;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        background: #2d3748;
    }

    .header-search__category {
        padding: 10px 15px;
        border: none;
        background: #2d3748;
        color: #a0aec0;
        font-size: 14px;
        cursor: pointer;
        outline: none;
        min-width: 140px;
        transition: background 0.3s;
    }

    .header-search__category:hover,
    .header-search__category:focus {
        background: #374151;
    }

    .header-search__input {
        flex: 1;
        padding: 10px 15px;
        border: none;
        outline: none;
        background: #2d3748;
        color: #fff;
        font-size: 14px;
        min-width: 100px;
    }

    .header-search__input::placeholder {
        color: #a0aec0;
    }

    .header-search__input:focus {
        background: #374151;
    }

    .header-search__button {
        padding: 10px 18px;
        background: transparent;
        color: #a0aec0;
        border: none;
        cursor: pointer;
        transition: color 0.3s;
        font-size: 16px;
    }

    .header-search__button:hover {
        color: #63b3ed;
    }

    .header-search__results {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        display: none;
        max-height: 400px;
        overflow-y: auto;
        padding: 8px 0;
        z-index: 1001;
    }

    .search-result__item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        text-decoration: none;
        color: #1a202c;
        transition: background 0.2s ease;
        border-bottom: 1px solid #f7fafc;
    }

    .search-result__item:last-child {
        border-bottom: none;
    }

    .search-result__item:hover {
        background: #f7fafc;
    }

    .search-result__item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        background: #f7fafc;
        flex-shrink: 0;
    }

    .search-result__item .info {
        flex: 1;
    }

    .search-result__item .name {
        font-weight: 500;
        font-size: 14px;
        color: #1a202c;
    }

    .search-result__item .price {
        font-size: 13px;
        color: #2b6cb0;
        font-weight: 600;
    }

    .search-result__item .category {
        font-size: 11px;
        color: #a0aec0;
    }

    .search-result__empty {
        padding: 30px;
        text-align: center;
        color: #718096;
    }

    .search-result__empty i {
        font-size: 24px;
        display: block;
        margin-bottom: 8px;
        color: #a0aec0;
    }

    /* Корзина */
    .header-actions {
        flex: 0 0 auto;
        position: relative;
    }

    .header-actions__cart {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: transparent;
        color: #e2e8f0;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 14px;
        position: relative;
        text-decoration: none;
    }

    .header-actions__cart:hover {
        background: #2d3748;
        color: #fff;
    }

    .header-actions__cart i {
        font-size: 20px;
        color: #63b3ed;
    }

    .header-actions__cart-text {
        color: #e2e8f0;
    }

    .header-actions__cart-badge {
        background: #e53e3e;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 5px;
        min-width: 20px;
        text-align: center;
    }

    .header-cart-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 340px;
        padding: 16px;
        display: none;
        z-index: 1001;
    }

    .header-cart-dropdown__items {
        max-height: 320px;
        overflow-y: auto;
    }

    .header-cart-dropdown__items::-webkit-scrollbar {
        width: 4px;
    }

    .header-cart-dropdown__items::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 4px;
    }

    .header-cart-dropdown__items::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    .cart-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .cart-dropdown-item:last-child {
        border-bottom: none;
    }

    .cart-dropdown-item__image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        background: #f7fafc;
        flex-shrink: 0;
    }

    .cart-dropdown-item__info {
        flex: 1;
    }

    .cart-dropdown-item__name {
        font-weight: 500;
        font-size: 14px;
        color: #1a202c;
        margin-bottom: 2px;
    }

    .cart-dropdown-item__price {
        font-size: 13px;
        color: #2b6cb0;
        font-weight: 600;
    }

    .cart-dropdown-item__remove {
        background: none;
        border: none;
        color: #e53e3e;
        cursor: pointer;
        font-size: 16px;
        padding: 4px 8px;
        transition: transform 0.3s;
        flex-shrink: 0;
    }

    .cart-dropdown-item__remove:hover {
        transform: scale(1.2);
    }

    .cart-dropdown__empty {
        text-align: center;
        padding: 20px 0;
        color: #718096;
    }

    .cart-dropdown__empty i {
        font-size: 36px;
        color: #e2e8f0;
        display: block;
        margin-bottom: 10px;
    }

    .cart-dropdown__footer {
        padding-top: 12px;
        border-top: 2px solid #f7fafc;
        margin-top: 8px;
    }

    .cart-dropdown__total {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 12px;
    }

    .cart-dropdown__button {
        display: block;
        padding: 10px;
        background: #2b6cb0;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s;
        border: none;
        width: 100%;
        cursor: pointer;
        font-size: 14px;
    }

    .cart-dropdown__button:hover {
        background: #1a4f7a;
        color: #fff;
    }

    /* Меню навигации */
    .header-nav {
        background: transparent;
        border-top: 1px solid rgba(255,255,255,0.08);
        margin-top: 8px;
        padding-top: 8px;
        width: 100%;
    }

    .header-nav__list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
        flex-wrap: wrap;
    }

    .header-nav__item {
        position: relative;
    }

    .header-nav__item--catalog {
        position: relative;
    }

    .header-nav__link {
        display: block;
        padding: 8px 16px;
        color: #e2e8f0;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
        border-radius: 8px;
    }

    .header-nav__link i {
        margin-right: 6px;
    }

    .header-nav__link:hover,
    .header-nav__link.active {
        background: #2d3748;
        color: #fff;
    }

    .header-nav__catalog-toggle {
        padding: 8px 16px;
        background: #2d3748;
        color: #e2e8f0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-nav__catalog-toggle:hover {
        background: #374151;
        color: #fff;
    }

    .header-nav__catalog-toggle i {
        color: #63b3ed;
    }

    .header-nav__dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 240px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 8px 0;
        list-style: none;
        display: none;
        z-index: 1000;
    }

    .header-nav__dropdown-item {
        position: relative;
    }

    .header-nav__dropdown-item:hover > .header-nav__subdropdown {
        display: block;
    }

    .header-nav__dropdown-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s;
        font-size: 14px;
    }

    .header-nav__dropdown-link:hover {
        background: #f7fafc;
    }

    .header-nav__dropdown-link i {
        margin-right: 10px;
        width: 18px;
        color: #2b6cb0;
        text-align: center;
    }

    .header-nav__subdropdown {
        position: absolute;
        top: 0;
        left: 100%;
        min-width: 200px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 8px 0;
        list-style: none;
        display: none;
        z-index: 1000;
    }

    .header-nav__subdropdown li a {
        display: block;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s;
        font-size: 14px;
    }

    .header-nav__subdropdown li a:hover {
        background: #f7fafc;
    }

    /* Анимация бейджа */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    .badge-pulse {
        animation: pulse 0.3s ease;
    }

    /* Адаптивность */
    @media (max-width: 991px) {
        .header .container {
            flex-wrap: wrap;
            gap: 12px;
        }

        .header-search {
            order: 3;
            flex: 1 1 100%;
            max-width: 100%;
        }

        .header-actions__cart-text {
            display: none;
        }

        .header-actions__cart {
            padding: 8px 12px;
        }

        .header-nav__list {
            overflow-x: auto;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .header-nav__list .header-nav__item--catalog {
            flex: 0 0 auto;
        }

        .header-nav__link {
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 13px;
        }

        .header-nav__catalog-toggle {
            padding: 6px 12px;
            font-size: 13px;
        }

        .header-cart-dropdown {
            min-width: 300px;
            right: -20px;
        }
    }

    @media (max-width: 576px) {
        .header-logo {
            font-size: 20px;
        }

        .header-logo__text {
            font-size: 20px;
        }

        .header-logo__img {
            width: 32px;
            height: 32px;
            font-size: 16px;
        }

        .header-search__category {
            min-width: 100px;
            font-size: 12px;
            padding: 8px 10px;
        }

        .header-search__input {
            font-size: 13px;
            padding: 8px 10px;
        }

        .header-search__button {
            padding: 8px 12px;
        }

        .header-actions__cart i {
            font-size: 18px;
        }

        .header-cart-dropdown {
            min-width: 280px;
            right: -40px;
            padding: 12px;
        }

        .header-nav__link {
            font-size: 12px;
            padding: 4px 10px;
        }
    }

    /* Стили для блока аутентификации в хедере */
.header-auth {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-left: 20px;
}

.header-auth__link {
    text-decoration: none;
    color: #333;
    font-size: 14px;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.header-auth__link:hover {
    color: #007bff; /* Или твой основной цвет */
}

.header-auth__link--register {
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
}

.header-auth__link--register:hover {
    background-color: #0056b3;
    color: white;
}

.header-auth__name {
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 5px;
}

.header-auth__logout-form {
    margin: 0;
}

.header-auth__logout {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s ease;
}

.header-auth__logout:hover {
    color: #a71d2a;
}

/* Адаптивность для мобильных */
@media (max-width: 768px) {
    .header-auth {
        margin-left: 10px;
        gap: 10px;
    }
    
    .header-auth__link {
        font-size: 12px;
    }
    
    .header-auth__link--register {
        padding: 6px 10px;
    }
}






</style>

<header class="header">
    <div class="container">
        <!-- Логотип -->
        <a href="{{ route('home') }}" class="header-logo">
            <div class="header-logo__img">S</div>
            <span class="header-logo__text">ShopName</span>
        </a>

        <!-- Поиск -->
        <div class="header-search">
            <form action="#" method="GET" class="header-search__form" id="search-form">
                <div class="header-search__wrapper">
                    <select name="category" class="header-search__category" aria-label="Категория">
                        <option value="">Все категории</option>
                        <option value="1">Электроника</option>
                        <option value="2">Одежда</option>
                        <option value="3">Дом и сад</option>
                        <option value="4">Красота</option>
                        <option value="5">Спорт</option>
                    </select>
                    <input
                        type="text"
                        name="query"
                        class="header-search__input"
                        placeholder="Поиск товаров..."
                        value=""
                        autocomplete="off"
                        id="search-input"
                    >
                    <button type="submit" class="header-search__button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="search-results" class="header-search__results"></div>
            </form>
        </div>

       <div class="header-actions">
    <!-- Корзина -->
    <button class="header-actions__cart" id="cart-toggle">
        <i class="fas fa-shopping-cart"></i>
        <span class="header-actions__cart-text">Корзина</span>
        <span class="header-actions__cart-badge" id="cart-count">0</span>
    </button>

    <div class="header-cart-dropdown" id="cart-dropdown">
        <div class="header-cart-dropdown__items" id="cart-items">
            <div class="cart-dropdown__empty">
                <i class="fas fa-shopping-cart"></i>
                Корзина пуста
            </div>
        </div>
    </div>

    <!-- Блок для ГОСТЕЙ (не вошедших) -->
    @guest
        <div class="header-auth guest-auth">
            <a href="{{ route('login') }}" class="header-auth__link header-auth__link--login">
                <i class="fas fa-sign-in-alt"></i> Войти
            </a>
            <a href="{{ route('register') }}" class="header-auth__link header-auth__link--register">
                <i class="fas fa-user-plus"></i> Регистрация
            </a>
        </div>
    @endguest

    <!-- Блок для АВТОРИЗОВАННЫХ пользователей -->
    @auth
        <div class="header-auth user-auth">
            <span class="header-auth__name">
                <i class="fas fa-user"></i> {{ auth()->user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="header-auth__logout-form">
                @csrf
                <button type="submit" class="header-auth__logout">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </button>
            </form>
        </div>
    @endauth
</div>  





        <!-- Навигация -->
        <nav class="header-nav">
            <ul class="header-nav__list">
                <li class="header-nav__item header-nav__item--catalog">
                    <button class="header-nav__catalog-toggle" id="catalog-toggle">
                        <i class="fas fa-bars"></i> Каталог
                    </button>
                    <ul class="header-nav__dropdown" id="catalog-dropdown">
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-laptop"></i> Электроника
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="header-nav__subdropdown">
                                <li><a href="#">Смартфоны</a></li>
                                <li><a href="#">Ноутбуки</a></li>
                                <li><a href="#">Планшеты</a></li>
                                <li><a href="#">Аксессуары</a></li>
                            </ul>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-tshirt"></i> Одежда
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="header-nav__subdropdown">
                                <li><a href="#">Мужская</a></li>
                                <li><a href="#">Женская</a></li>
                                <li><a href="#">Детская</a></li>
                            </ul>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-home"></i> Дом и сад
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-heart"></i> Красота
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-running"></i> Спорт
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-gamepad"></i> Игрушки
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="header-nav__item">
                    <a href="{{ route('home') }}" class="header-nav__link active">
                        <i class="fas fa-home"></i> Главная
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-box"></i> Товары
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-tags"></i> Акции
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-newspaper"></i> Блог
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-phone"></i> Контакты
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
