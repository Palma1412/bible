const buttonProduct = document.getElementById('button-product');
const modal = document.getElementById("myModal");
const span = document.getElementsByClassName("close")[0];

buttonProduct.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

async function productAdd() {
    try {
        const url = "http://127.0.0.1:8000";
        const response = await fetch(url + '/api/products', { method: 'GET' });
        
        const data = await response.json();
        
        const list = document.getElementById('product-main');
        
        list.innerHTML = data.map(hit => {
            const imageUrl = hit.image.startsWith('http') ? hit.image : url + "/" + hit.image;
            return `
                 <div class="div-main" id=${hit.id}>
                    <img src="${imageUrl}" class="img-lolo">
                    <p>Name: ${hit.name}</p>
                    <p>Id: ${hit.id}</p>
                    <p>Price: ${hit.price}</p>
                    <div>
                        <button id="${hit.id}" class="iaiko" onClick="getdoor(this)">Change</button>
                        <button id=${hit.id} onClick="getdetails(this)">Delete</button>
                    </div>
                </div> 
            `;
        }).join('');
    } catch (error) {
        console.error(error);
    }
} 
productAdd();

async function getdetails(obj) {
    try {
        const url = "http://127.0.0.1:8000";
        await fetch(url + `/api/products/${obj.id}`, { method: 'DELETE' });
        
        location.reload();
    } catch (error){
        console.log(error);
    }
}

async function getdoor(obj) {
    try {
        const url = "http://127.0.0.1:8000";
        
        // Получаем данные о продукте
        const response = await fetch(`${url}/api/products/${obj.id}`, { method: 'GET' });
        
        if (!response.ok) {
            throw new Error('Ошибка при получении данных');
        }

        const hit = await response.json();
        showChangeModal(hit);
        
    } catch (error) {
        console.error(error);
    }
}

function showChangeModal(hit) {
    const changeData = document.getElementById('changeModal');
    
    changeData.innerHTML = `
        <div class="modal-content">
            <span class="closeId">&times;</span>
            <h2>Окно для изменения товара</h2>
            <input placeholder="id" id="idid" value="${hit.id}" readonly/>
            <input placeholder="name" id="namename" value="${hit.name}"/>
            <input placeholder="price" id="priceprice" value="${hit.price}"/>
            <input placeholder="description" id="descriptiondescription" value="${hit.description}"/>
            <input placeholder="height" id="heightheight" value="${hit.height}"/>
            <input placeholder="width" id="widthwidth" value="${hit.width}" />
            <input placeholder="depth" id="depthdepth" value="${hit.depth}" />
            <input type='file' placeholder='image' id='imageimage'/>
            <button class='add' id='aDD'>Change</button>
        </div>
    `;
    
    changeData.style.display = "block"; 

    document.getElementsByClassName("closeId")[0].onclick = () => {
        changeData.style.display = "none";
    };

    window.onclick = (event) => {
        if (event.target == changeData) {
            changeData.style.display = "none";
        }
    };

    document.getElementById('aDD').onclick = async () => {
        await updateProduct(hit.id);
    };
}

async function updateProduct(productId) {
    const formDataProduct = new FormData();
    
    formDataProduct.append('name', document.getElementById('namename').value);
    formDataProduct.append('price', document.getElementById('priceprice').value);
    formDataProduct.append('description', document.getElementById('descriptiondescription').value);
    formDataProduct.append('height', document.getElementById('heightheight').value);
    formDataProduct.append('width', document.getElementById('widthwidth').value);
    formDataProduct.append('depth', document.getElementById('depthdepth').value);

    const imageInput = document.getElementById('imageimage');
    if (imageInput.files.length > 0) {
        formDataProduct.append('image', imageInput.files[0]);
    }

    try {
        const url = "http://127.0.0.1:8000";
        const updateResponse = await fetch(`${url}/api/products/${productId}`, { 
            method: 'POST',
            body: formDataProduct,
        });

        if (!updateResponse.ok) {
            throw new Error('Ошибка при обновлении данных');
        }

        alert("Данные успешно обновлены!");
        
        // Закрыть модальное окно после успешного обновления
        document.getElementById('changeModal').style.display = "none";

    } catch (error) {
        console.error(error);
        alert("Произошла ошибка при обновлении данных.");
    }
}

document.getElementById('addddddd').addEventListener('click', async () => {

    const formData= new FormData();

    formData.append('name', document.getElementById('name').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('image', document.getElementById('image').files[0]);
    formData.append('description', document.getElementById('description').value);
    formData.append('height', document.getElementById('height').value);
    formData.append('width', document.getElementById('width').value);
    formData.append('depth', document.getElementById('depth').value);

    try{
         const url= "http://127.0.0.1:8000";
         const response= await fetch(url + `/api/products`, { method:'POST', body:formData });
         
         if(!response.ok){
              throw new Error(`Ошибка HTTP:${response.status}`);
          }

          location.reload();
          const result= await response.json();
          console.log(`Продукт успешно добавлен:${result}`);
      } catch(error){
          console.error(`Произошла ошибка:${error}`);
      }
});