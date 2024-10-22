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
    img.className = 'banner_images';
    cell1.appendChild(img);

    let fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.className = 'file-input';
    fileInput.setAttribute('onchange', `previewImage(event, ${rowCount})`);
    fileInput.setAttribute('name', 'banner_images[]');  
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

function deleteExistingRow(bannerId, deleteUrl) {
    if (confirm('削除しますか？')) {
        $.ajax({
            url: deleteUrl,  
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), 
            },
            success: function(response) {
                alert('削除されました');
                $(`#banner-${bannerId}`).closest('tr').remove();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert(xhr.responseJSON.error);
                } else {
                    alert('予期しないエラーが発生しました。');
                }
            }
        });
    }
}