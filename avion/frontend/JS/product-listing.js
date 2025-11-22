window.onload = async function() {
    const productId = localStorage.getItem('selectedProductId');

    if (!productId) {
        console.error('Ошибка: ID товара отсутствует в localStorage');
        return;
    }

    try {
        const url = "http://127.0.0.1:8000";
        const response = await fetch(url + `/api/products/${productId}`);

        if (!response.ok) {
            throw new Error(`Ошибка сети: ${response.status}`);
        }

        const hit = await response.json();

        const productDetail = document.getElementById('product-detail');

        if (!productDetail) {
            console.error("Ошибка: Элемент #product-detail не найден.");
            return;
        }

        productDetail.innerHTML = `
            <div class="container">
                <img src="${hit.image.startsWith('http') ? hit.image : `${url}/${hit.image}`}" alt="product" />

                <div class="product-info">
                    <div class="description">
                        <h1>${hit.name || "Нет данных"}</h1>
                        <h3>£${hit.price || "Не указана"}</h3>
                        <h4>Description</h4>
                        <p>${hit.description || "Описание отсутствует"}</p>
                    </div>
                    <h4 class="dis">Dimensions</h4>
                    <div class="dimensions">
                        <div><h4>Height</h4><p>${hit.height}</p></div>
                        <div><h4>Width</h4><p>${hit.width}</p></div>
                        <div><h4>Depth</h4><p>${hit.depth}</p></div>
                    </div>
                    <div class="amount">
                        <div class="quantity">
                            <h3>Amount:</h3>
                            <button id="amount-minus">-</button>
                            <input type="text" value="1" id="amount"/>
                            <button id="amount-plus">+</button>
                        </div>
                        <button>Add to cart</button>
                    </div>
                </div>
            </div>
        `;
    } catch (error) {
        console.error('Ошибка при загрузке товара:', error);
    }

    const amountMinus = document.getElementById('amount-minus');
    const amountPlus = document.getElementById('amount-plus');
    const amount = document.getElementById('amount');

    amountMinus.addEventListener('click', function () {
        let currentValue = parseInt(amount.value);
        if (currentValue > 1) {
            amount.value = currentValue - 1;
        }
    });

    amountPlus.addEventListener('click', function () {
        let currentValue = parseInt(amount.value);
        amount.value = currentValue + 1;
    });
}

loadProductId();