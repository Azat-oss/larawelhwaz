@extends('layouts.main')

@section('title', 'Корзина')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">
        <i class="fas fa-shopping-cart text-primary me-2"></i>
        Корзина
    </h1>

    <!-- Загрузчик -->
    <div id="cart-loader" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
        <p class="mt-3 text-muted">Загрузка корзины...</p>
    </div>

    <!-- Содержимое корзины -->
    <div id="cart-content" style="display: none;">
        
        <!-- Пустая корзина -->
        <div id="cart-empty" class="text-center py-5" style="display: none;">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">Ваша корзина пуста</h3>
            <p class="text-muted">Добавьте товары из каталога</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fas fa-home me-2"></i>Перейти в каталог
            </a>
        </div>

        <!-- Товары в корзине -->
        <div id="cart-items-container">
            <div class="row">
                <!-- Список товаров -->
                <div class="col-lg-8">
                    <div id="cart-items-list"></div>
                </div>

                <!-- Итого -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Итого</h5>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Товары:</span>
                                <span id="cart-total-count">0 шт.</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Сумма:</span>
                                <strong id="cart-total-price" class="text-primary fs-5">0 ₸</strong>
                            </div>

                            <hr>

                            <button class="btn btn-success w-100 mb-2" disabled id="checkout-btn">
                                <i class="fas fa-check-circle me-2"></i>Оформить заказ
                            </button>

                            <button class="btn btn-outline-danger w-100" id="clear-cart-btn">
                                <i class="fas fa-trash me-2"></i>Очистить корзину
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cart-item {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .cart-item__image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        background: #f7fafc;
    }

    .cart-item__name {
        font-weight: 600;
        font-size: 16px;
        color: #1a202c;
        margin-bottom: 4px;
    }

    .cart-item__category {
        font-size: 13px;
        color: #a0aec0;
        margin-bottom: 8px;
    }

    .cart-item__price {
        font-size: 18px;
        font-weight: 700;
        color: #2b6cb0;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        border: 2px solid #e2e8f0;
        background: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 16px;
        color: #4a5568;
    }

    .quantity-btn:hover {
        background: #2b6cb0;
        border-color: #2b6cb0;
        color: #fff;
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quantity-input {
        width: 60px;
        height: 36px;
        text-align: center;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #2b6cb0;
    }

    .cart-item__remove {
        background: none;
        border: none;
        color: #e53e3e;
        cursor: pointer;
        font-size: 20px;
        padding: 8px;
        transition: all 0.2s;
        border-radius: 8px;
    }

    .cart-item__remove:hover {
        background: #fed7d7;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .cart-item__image {
            width: 80px;
            height: 80px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let cartData = null;

    // Загрузка корзины при открытии страницы
    loadCart();

    // Функция загрузки корзины
    function loadCart() {
        $.ajax({
            url: '/cart',
            type: 'GET',
            success: function(response) {
                cartData = response.data;
                renderCart();
            },
            error: function() {
                showError('Ошибка загрузки корзины');
            }
        });
    }

    // Отрисовка корзины
    function renderCart() {
        $('#cart-loader').hide();
        $('#cart-content').show();

        if (!cartData.items || cartData.items.length === 0) {
            $('#cart-empty').show();
            $('#cart-items-container').hide();
            updateCartBadge(0);
        } else {
            $('#cart-empty').hide();
            $('#cart-items-container').show();
            
            // Отрисовка списка товаров
            let html = '';
            cartData.items.forEach(function(item) {
                html += `
                    <div class="cart-item" data-product-id="${item.id}">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-4">
                                <img src="/${item.image}" alt="${item.name}" class="cart-item__image">
                            </div>
                            <div class="col-md-4 col-8">
                                <div class="cart-item__name">${item.name}</div>
                                ${item.category ? `<div class="cart-item__category">${item.category}</div>` : ''}
                                <div class="cart-item__price">${formatPrice(item.price)} ₸</div>
                            </div>
                            <div class="col-md-3 col-6 mt-3 mt-md-0">
                                <div class="quantity-control">
                                    <button class="quantity-btn decrease-qty" data-product-id="${item.id}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" value="${item.quantity}" 
                                           min="1" data-product-id="${item.id}">
                                    <button class="quantity-btn increase-qty" data-product-id="${item.id}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mt-3 mt-md-0 text-end">
                                <div class="fw-bold text-primary">${formatPrice(item.subtotal)} ₸</div>
                            </div>
                            <div class="col-md-1 col-12 mt-3 mt-md-0 text-end">
                                <button class="cart-item__remove remove-item" data-product-id="${item.id}" title="Удалить">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            $('#cart-items-list').html(html);
            
            // Обновление итогов
            $('#cart-total-count').text(cartData.count + ' шт.');
            $('#cart-total-price').text(formatPrice(cartData.total) + ' ₸');
            $('#checkout-btn').prop('disabled', false);
            
            updateCartBadge(cartData.count);
        }
    }

    // Уменьшение количества
    $(document).on('click', '.decrease-qty', function() {
        const productId = $(this).data('product-id');
        const item = cartData.items.find(i => i.id == productId);
        
        if (item && item.quantity > 1) {
            updateQuantity(productId, item.quantity - 1);
        }
    });

    // Увеличение количества
    $(document).on('click', '.increase-qty', function() {
        const productId = $(this).data('product-id');
        const item = cartData.items.find(i => i.id == productId);
        
        if (item) {
            updateQuantity(productId, item.quantity + 1);
        }
    });

    // Изменение количества вручную
    $(document).on('change', '.quantity-input', function() {
        const productId = $(this).data('product-id');
        let quantity = parseInt($(this).val());
        
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
        }
        
        updateQuantity(productId, quantity);
    });

    // Удаление товара
    $(document).on('click', '.remove-item', function() {
        const productId = $(this).data('product-id');
        const item = cartData.items.find(i => i.id == productId);
        
        if (confirm(`Удалить "${item.name}" из корзины?`)) {
            removeFromCart(productId);
        }
    });

    // Очистка корзины
    $('#clear-cart-btn').on('click', function() {
        if (confirm('Вы уверены, что хотите очистить корзину?')) {
            clearCart();
        }
    });

    // Функция обновления количества
    function updateQuantity(productId, quantity) {
        $.ajax({
            url: `/cart/update/${productId}`,
            type: 'PUT',
            data: { quantity: quantity },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                cartData = response.data;
                renderCart();
                showSuccess('Количество обновлено');
            },
            error: function() {
                showError('Ошибка обновления количества');
            }
        });
    }

    // Функция удаления товара
    function removeFromCart(productId) {
        $.ajax({
            url: `/cart/remove/${productId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                cartData = response.data;
                renderCart();
                showSuccess('Товар удален из корзины');
            },
            error: function() {
                showError('Ошибка удаления товара');
            }
        });
    }

    // Функция очистки корзины
    function clearCart() {
        $.ajax({
            url: '/cart/clear',
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                cartData = response.data;
                renderCart();
                showSuccess('Корзина очищена');
            },
            error: function() {
                showError('Ошибка очистки корзины');
            }
        });
    }

    // Обновление бейджа в хедере
    function updateCartBadge(count) {
        $('#cart-count').text(count);
        if (count > 0) {
            $('#cart-count').addClass('badge-pulse');
            setTimeout(() => {
                $('#cart-count').removeClass('badge-pulse');
            }, 300);
        }
    }

    // Форматирование цены
    function formatPrice(price) {
        return Number(price).toLocaleString('ru-RU');
    }

    // Показ успешного сообщения
    function showSuccess(message) {
        // Можно добавить toast notification
        console.log('✓', message);
    }

    // Показ ошибки
    function showError(message) {
        alert('Ошибка: ' + message);
    }
});
</script>
@endpush