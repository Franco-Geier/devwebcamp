<script src="https://www.paypal.com/sdk/js?client-id=Ac_fY86XhftnKA9QImR926Mj3wS4EoD22ZWdAydYCH8IVc00hgdCrES1iJhncVwKhA_-4ZlmEK0eOgom"></script>

<main class="register">
    <h2 class="register__heading"><?php echo $title; ?></h2>
    <p class="register__description">Elige tu plan</p>

    <div class="packages__grid">
        <div class="package">
            <h3 class="package__name">Pase Gratis</h3>
            <ul class="package__list">
                <li class="package__element">Acceso Virtual a DevWebCamp.</li>
            </ul>
            <p class="package__price">$0</p>

            <form action="/end-register/free" method="POST">
                <input type="submit" class="packages__submit" value="Inscripción Gratis">
            </form>
        </div>

        <div class="package">
            <h3 class="package__name">Pase Presencial</h3>
            <ul class="package__list">
                <li class="package__element">Acceso Presencial a DevWebCamp.</li>
                <li class="package__element">Pase por 2 días.</li>
                <li class="package__element">Acceso a talleres y conferencias.</li>
                <li class="package__element">Acceso a las grabaciones.</li>
                <li class="package__element">Camisa del evento.</li>
                <li class="package__element">Comida y bebida.</li>
            </ul>
            <p class="package__price">$199</p>
            <div id="paypal-button-container"></div>
        </div>

        <div class="package">
            <h3 class="package__name">Pase Virtual</h3>
            <ul class="package__list">
                <li class="package__element">Acceso Virtual a DevWebCamp.</li>
                <li class="package__element">Pase por 2 días.</li>
                <li class="package__element">Acceso a talleres y conferencias.</li>
                <li class="package__element">Acceso a las grabaciones.</li>
            </ul>
            <p class="package__price">$49</p>
        </div>
    </div>
</main>

<script>
    paypal.Buttons({
        style: {
            shape: 'rect',
            color: 'blue',
            layout: 'vertical',
            label: 'pay',
        },

        // Configuración de la compra
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    "description": 1,
                    amount: {
                        value: 199
                    }
                }]
            });
        },

        // Ejecución después del pago
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                // console.log("Capture result", orderData, JSON.stringify(orderData, null, 2));
                const data = new FormData();
                data.append("package_id", orderData.purchase_units[0].description);
                data.append("pay_id", orderData.purchase_units[0].payments.captures[0].id);
                fetch("/end-register/pay", {
                    method: "POST",
                    body: data
                })
                .then(response => response.json())
                .then(result => {
                    if(result.result) {
                        window.location.href = '/end-register/conferences';
                    }
                })
            });
        }
    }).render('#paypal-button-container');
</script>