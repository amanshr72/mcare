
$(document).ready(function () {
    $('#item_name_val').select2({
        placeholder: 'Select Item Name',
        allowClear: true,
    });

    $('#item_name_val').change(function () {
        var itemName = $(this).val();

        $.ajax({
            url: '/getItemDetails/' + itemName,
            type: 'GET',
            success: function (resp) {
                $('#batche_no_val').empty();
                $('#mfg_date_val').empty();

                $.each(resp.itemName, function (key, val) {
                    if (val.batch_number !== null && val.batch_number !== "") {
                        $('#batche_no_val').append('<option value="' + val.batch_number + '">' + val.batch_number + '</option>');
                    }
                });
                $.each(resp.itemName, function (key, val) {
                    if (val.mfg_date !== null && val.mfg_date !== "") {
                        $('#mfg_date_val').append('<option value="' + val.mfg_date + '">' + val.mfg_date + '</option>');
                    }
                });
                (resp.itemName[0] != undefined) ? $('#quantity_2_val').val(resp.itemName[0].quantity) : '';
                $('#batche_no_val').change(function () {
                    $('#quantity_2_val').empty();
                    var selectedBatchNumber = $(this).val();
                    var selectedItem = resp.itemName.find(function (item) {
                        return item.batch_number == selectedBatchNumber;
                    });
                    $('#quantity_2_val').val(selectedItem ? selectedItem.quantity : '');
                }); 
            },
            error: function (resp) {
                console.log('Error:', resp);
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const getSelectedValue = (element) => {
        if (element && element.options && element.options.length > 0) {
            return element.options[element.selectedIndex]?.value || '';
        }
        return '';
    };

    let listItemsInput = document.getElementById('listItems');
    let listBody = document.getElementById('listBody');
    let addToListButton = document.getElementById('addToList');
    let index = 1;
    let listItemsArray = [];

    const removeRow = (row, rowIndex) => {
        listItemsArray.splice(rowIndex, 1);
        listItemsInput.value = JSON.stringify(listItemsArray);
        listBody.removeChild(row);
    };

    addToListButton.addEventListener('click', function () {
        let formData = {
            itemNameVal: getSelectedValue(document.getElementById('item_name_val')),
            batcheNoVal: getSelectedValue(document.getElementById('batche_no_val')),
            mfgDateVal: new Date(getSelectedValue(document.getElementById('mfg_date_val'))).toLocaleDateString('en-GB'),
            quantityVal: document.getElementById('quantity_val')?.value || '',
            quantity2Val: document.getElementById('quantity_2_val')?.value || '',
        };

        listItemsArray.push(formData);
        listItemsInput.value = JSON.stringify(listItemsArray);

        // Create a new row and append it to the list body
        let newRow = document.createElement('tr');
        newRow.classList.add('bg-white', 'border-b', 'dark:bg-gray-800', 'dark:border-gray-700');
        newRow.innerHTML = `
            <td class="p-3"><button type="button" class="removeItem">remove</button></td>
            <td class="p-3"><span>${formData.itemNameVal}</span></td>
            <td class="p-3"><span>${formData.batcheNoVal}</span></td>
            <td class="p-3"><span>${formData.mfgDateVal}</span></td>
            <td class="p-3"><span>${formData.quantity2Val}</span></td>
            <td class="p-3"><span>${formData.quantityVal}</span></td>
        `;
        listBody.appendChild(newRow);

        // Add event listener to the "Remove" button
        let removeItemButtons = document.querySelectorAll('.removeItem');
        let rowIndex = index - 1;
        removeItemButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                removeRow(newRow, rowIndex);
            });
        });

        index++;
    });
});
