window.onload = async function () {
    try {
        const url = "http://127.0.0.1:8000";
        const response = await fetch(url + '/api/products', {
            method: 'GET'
        });

        if (!response.ok) throw new Error(`Ошибка HTTP: ${response.status}`);

        const data = await response.json();

        const list = document.getElementById('product-list');

        list.innerHTML = data.map(hit => {
            const imageUrl = hit.image.startsWith('http') ? hit.image : url +"/"+ hit.image;
            return `
                <div class="listing">
                    <div>
                        <a href="#" class="product-link" data-id="${hit.id}">
                            <img class="img" src="${imageUrl}" alt="${hit.name || 'Изображение'}" />
                            <h3>${hit.name || 'нет данных'}</h3>
                            <p>£${hit.price}</p>
                        </a>
                    </div>
                </div>
            `;
        }).join('');

        list.addEventListener('click', function (event) {
            const link = event.target.closest('.product-link');
            if (!link) return;

            event.preventDefault();
            const productId = link.getAttribute('data-id');
            localStorage.setItem('selectedProductId', productId);
            window.location.href = 'product-listing.html';
        });

    } catch (error) {
        console.error('Ошибка при загрузке продуктов:', error);
    }
};
