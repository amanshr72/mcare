let currentStep = 1;
 
function captureFormValuesAndNext(nextStep) {
    const getSelectedValue = (element) => element.options[element.selectedIndex]?.value || '';

    let s1FormValues = {
        vendorName: getSelectedValue(document.getElementById('vendor_name')),
        locationVal: getSelectedValue(document.getElementById('location')),
        refrenceDocumentNo: document.getElementById('refrence_document_no')?.value || '',
        refrenceDate: document.getElementById('refrence_date')?.value || '',
        userPrefix: document.getElementById('user_prefix')?.value || '',
    };

    document.getElementById(`step${currentStep}`).style.display = 'none';
    document.getElementById(`step${nextStep}`).style.display = 'block';
    currentStep = nextStep;

    // Set the value of the input based on the s1FormValues
    const fieldsToSet = ['vendorName', 'locationVal', 'refrenceDocumentNo', 'refrenceDate', 'userPrefix',];
    fieldsToSet.forEach(field => {
        document.getElementById(field).value = s1FormValues[field] || '';
    });
}

function previousStep(prevStep) {
    document.getElementById(`step${currentStep}`).style.display = 'none';
    document.getElementById(`step${prevStep}`).style.display = 'block';
    currentStep = prevStep;
}

/* Ajax Call to retrieve feild values from Item Name */
$(document).ready(function () {
    $('#item_name_val').change(function () {
        var itemName = $(this).val();

        $.ajax({
            url: '/getItemDetailsByName/' + itemName,
            type: 'GET',
            success: function (resp) {
                console.log(resp.batchDetails);

                $('#item_code_val').val(resp.item.item_code);
                $('#available_stock_val').val(resp.item.avl_stock);
                $('#price_val').val(resp.item.price);
                $('#tax_val').val(resp.item.gst);
                
                $('#batchSuggestions').empty();

                if(resp.batchDetails.length > 0){
                    $.each(resp.batchDetails, function (key, val) {
                        if (val.batch_number !== null && val.batch_number !== "") {
                            $('#batchSuggestions').append('<option value="' + val.batch_number + '">' + val.batch_number + '</option>');
                        }
                    });
                    $('#batche_no_val').change(function () {
                        $('#mfg_date_val').empty(); $('#mfg_name_val').empty();
                        var selectedBatchNumber = $(this).val();
                        var selectedBatchDetails = resp.batchDetails.find(function (batch) {
                            return batch.batch_number == selectedBatchNumber;
                        });
                        if (selectedBatchDetails) {
                            var formattedMfgDate = selectedBatchDetails.mfg_date.split(' ')[0];
                            $('#mfg_date_val').val(formattedMfgDate);
                            $('#mfg_name_val').val(selectedBatchDetails.mfg_name);
                        }
                    }); 
                }
            },
            error: function (resp) {
                console.log('Error:', resp);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const getSelectedValue = (element) => element.options[element.selectedIndex]?.value || '';
    let listItemsInput = document.getElementById('listItems');
    let listBody = document.getElementById('listBody');
    let listContainer = document.getElementById('listContainer');
    let addToListButton = document.getElementById('addToList');
    let index = 1;
    let listItemsArray = [];

    addToListButton.addEventListener('click', function () {
        let getPrice = () => parseFloat(document.getElementById('price_val').value) || 0;
        let getTax = () => parseFloat(document.getElementById('tax_val').value) || 0;
        
        let formData = {
            itemNameVal: getSelectedValue(document.getElementById('item_name_val')),
            vendorName: document.getElementById('vendor_name')?.value || '',
            itemCodeVal: document.getElementById('item_code_val')?.value || '',
            lotNo: null,
            quantityVal: document.getElementById('quantity_val')?.value || '',
            priceVal: document.getElementById('price_val')?.value || '',
            taxAmount: getPrice() * (getTax() / 100),
            grossAmount: getPrice(),
            finalAmount: getPrice() + getPrice() * (getTax() / 100),
            mfgDateVal: document.getElementById('mfg_date_val')?.value || '',
            mfgNameVal: document.getElementById('mfg_name_val')?.value || '',
            expiryDate: null,
            availableStockVal: document.getElementById('available_stock_val')?.value || '',
            batcheNoVal: document.getElementById('batche_no_val')?.value || '',
            taxVal: document.getElementById('tax_val').value,
        };
        console.log(formData.batcheNoVal);
        listItemsArray.push(formData);
        listItemsInput.value = JSON.stringify(listItemsArray);

        // Create a new row and append it to the list body
        let newRow = document.createElement('tr');
        newRow.classList.add('bg-white', 'border-b', 'dark:bg-gray-800', 'dark:border-gray-700');
        newRow.innerHTML = `
            <td class="p-3"><button type="button" class="removeItem">remove</button></td>
            <td class="p-3"><span>${formData.itemNameVal}</span></td>
            <td class="p-3"><span>${formData.vendorName}</span></td>
            <td class="p-3"><span>${formData.itemCodeVal}</span></td>
            <td class="p-3"><span>${formData.availableStockVal}</span></td>
            <td class="p-3"><span>${formData.quantityVal}</span></td>
            <td class="p-3"><span>${formData.batcheNoVal}</span></td>
            <td class="p-3"><span>${formData.mfgDateVal}</span></td>
            <td class="p-3"><span>${formData.mfgNameVal}</span></td>
            <td class="p-3"><span>₹${formData.priceVal}</span></td>
            <td class="p-3"><span>${formData.taxVal}%</span></td>
            <td class="p-3"><span>₹${formData.taxAmount.toFixed(2)}</span></td>
            <td class="p-3"><span>₹${formData.grossAmount}</span></td>
            <td class="p-3"><span>₹${formData.finalAmount.toFixed(2)}</span></td>
        `;
        listBody.appendChild(newRow);

        // Add event listener to the "Remove" button
        let removeItemButtons = document.querySelectorAll('.removeItem');
        let currentIndex = index;
        removeItemButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                let rowIndex = currentIndex - 1; 

                listItemsArray.splice(rowIndex, 1);
                listItemsInput.value = JSON.stringify(listItemsArray);

                listBody.removeChild(newRow);
            });
        });

        index++;
    });
});