

async function adminPanel() {
    try {
        const url = "http://127.0.0.1:8000";
        const response = await fetch(url + '/api/users', {
            method: 'GET'
        });
        
        if (!response.ok) {
            throw new Error(`Ошибка сети: ${response.status}`);
        }

        const data = await response.json()

        const usersTable = document.getElementById('users-table')

        usersTable.innerHTML = data.map(hit => {
            return  `
            <div class="userName">
                <p class="user">${hit.name}</p>
                <button class="but" type="submit"  id="${hit.id}" onClick="getdetails(this)">Delete</button>
            </div>     
        `;
        }).join('');
        

    } catch (error) {
        console.error(error)
    }
}

adminPanel()

async function getdetails(obj) {
    try {
        const url = "http://127.0.0.1:8000";
        const response = await fetch(url + `/api/users/${obj.id}`, {
            method: 'DELETE'
        })
        location.reload();


        
    } catch (error) {
        console.error(error)
    }
    
}

getdetails()






