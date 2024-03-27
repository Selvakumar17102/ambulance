window.addEventListener('load', (event) => {
    setInterval(function(){
        $.ajax({
            type: "POST",
            url: "ajax/checkarrivedOrder1.php",
            success: function(data){
                document.getElementById('arrivedTablebody').innerHTML = data
            }
        });
        $.ajax({
            type: "POST",
            url: "ajax/checkprocessingOrder1.php",
            success: function(data){
                document.getElementById('processingTablebody').innerHTML = data
            }
        });
        $.ajax({
            type: "POST",
            url: "ajax/checkreadyOrder1.php",
            success: function(data){
                document.getElementById('readyTablebody').innerHTML = data
            }
        });
        $.ajax({
            type: "POST",
            url: "ajax/checkpickupOrder1.php",
            success: function(data){
                document.getElementById('pickupTablebody').innerHTML = data
            }
        });
    }, 10000)
})
function assignDelivery(order_id,delivery_partner_id){
    $.ajax({
        type: "POST",
        url: "ajax/assignDelivery.php",
        data:{'order_id':order_id,'delivery_partner_id':delivery_partner_id},
        success: function(data){
            Snackbar.show({
                text: data,
                pos: 'bottom-right',
                actionText: 'Success',
                actionTextColor: '#8dbf42',
                duration: 5000
            });
            setInterval(() => {
                location.reload()
            }, 500);
        }
    });
}
function deliveryCheck(event,order_id){
    $.ajax({
        type: "POST",
        url: "ajax/assignDeliveryOrder.php",
        data:{'order_id':order_id},
        success: function(data){
            if(data == 'false'){
                event.preventDefault()
                Snackbar.show({
                    text: "No delivery partner has been assigned.",
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
            } else{
                return true
            }
        }
    });
}