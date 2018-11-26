self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const sendNotification = body => {
        // you could refresh a notification badge here with postMessage API
        var obj = JSON.parse(body);
        const title = obj.title;

        return self.registration.showNotification(title, {
            image: obj.icon,
            body: obj.body,
            data: {
                click_url: 'https://www.google.com'
              }
        });
    };

    if (event.data) {
        const message = event.data.text();
        event.waitUntil(sendNotification(message));
    }
});



self.addEventListener('notificationclick', function(event) {
    const clickedNotification = event.notification;
    clickedNotification.close();

    //var obj = JSON.parse(event.data.text());
    event.waitUntil(clients.openWindow(clickedNotification.data.click_url));
  });