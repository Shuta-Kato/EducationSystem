function previewImage(event, rowId) 
            {
                let reader = new FileReader();
                reader.onload = function() 
                {
                    let preview = document.getElementById(`preview${rowId}`);
                    preview.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }

            let rowCount = 1;
            function addRow() 
            {
                rowCount++;
                
                let table = document.getElementById('bannerTable').getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();
                let cell1 = newRow.insertCell(0);
                let cell2 = newRow.insertCell(1);
                let cell3 = newRow.insertCell(2);

                let img = document.createElement('img');
                img.id = `preview${rowCount}`;
                img.className = 'banner_image';
                cell1.appendChild(img);

                let fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.className = 'file-input';
                fileInput.setAttribute('onchange', `previewImage(event, ${rowCount})`);
                cell2.appendChild(fileInput);

                let deleteButton = document.createElement('button');
                deleteButton.className = 'delete_button';
                deleteButton.innerHTML = 'ー';
                deleteButton.setAttribute('onclick', 'deleteRow(this)');
                cell3.appendChild(deleteButton);
            }

            function deleteRow(button) 
            {
                let row = button.closest('tr');
                row.remove();
            }