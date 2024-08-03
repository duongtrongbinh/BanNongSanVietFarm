import './bootstrap';

import moment from 'moment';
Echo.channel(`notifications`)
    .listen('SystemNotificationEvent', (event) => {
        let message = event.notification;
        let notification = document.getElementById('notification');
         // add new
        newNotification(notification,message)

        // count
        let total_notification = document.getElementById('total-notification');

        let total_notificationNew = document.getElementById('total-notification-new');

        countNotification(total_notification);

        countNotification(total_notificationNew);
});


function newNotification(notification,data){
    let element = data.data;
    let html = `
        <li>
            <hr class="dropdown-divider">
        </li>
      <a href="/admin/orders/:order_id/edit?query=:notification_id">
                <li class="notification-item bg-light">
                    <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck1" name="notifications[]" value="${ data.id }">
                    <i class="bi bi-bag-check-fill text-success"></i>
                    <div>
                        <h4>${element.type}</h4>
                        <span>${element.message}
                        <h6>${element.customer}</h6>
                        </span>
                         <p>${formatTime(data.created_at)}</p>
                    </div>
                </li>
            </a>
         <li>
            <hr class="dropdown-divider">
        </li>`
    html = html.replace(':order_id', element.order_id).replace(':notification_id', data.id);
    notification.insertAdjacentHTML('afterbegin', html);
}

function countNotification(element){
    let after_total =0
    after_total =  +element.innerText + 1
    element.innerText = after_total;
}



function formatTime(createdAt) {
    let timeDiff = moment(createdAt).fromNow();
    return toTitleCase(timeDiff);
}

// Function to convert string to title case
function toTitleCase(str) {
    return str.replace(/\b\w+/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}
