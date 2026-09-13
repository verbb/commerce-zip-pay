# Testing a Zip Payment

Zip Pay connects a Commerce checkout to the customer's Zip payment flow. The customer leaves your storefront to complete the provider step and returns to Commerce to finish processing the payment. The return journey is part of the integration and must be tested along with the outgoing request.

## Connect the Gateway

Create the Zip Pay gateway under **Commerce → Settings → Gateways**. Enter the **API Key**, using the private key supplied for your Zip merchant account. The field supports environment variables. Enable **Test mode?** for a test connection and use credentials appropriate to that environment.

Your storefront needs a Commerce checkout that selects this gateway and handles the provider redirect. Installing the plugin does not create those templates.

## Check the Customer Journey

Place an identifiable test order, choose Zip in your checkout, and follow the provider's test-payment flow. Confirm that the customer reaches the provider, returns to your site and sees the correct result for the order.

Inspect the order's transaction history in Commerce and compare it with the provider-side result. Also test an unsuccessful or cancelled payment. The gateway checks the returned result and routes failed payments back to the order's cancellation URL; your checkout should make that page useful to the customer, with a way to return to the cart or choose another payment method.

If the return does not complete, check the transaction response and your site's checkout/return URLs, then verify that the private key and test mode belong to the same environment. Do not mark an order as paid based solely on a customer returning to a page.

## Prepare the Live Gateway

After checking both the successful and unsuccessful paths, use the live private key and disable test mode for the live gateway. Confirm the first live transaction in Commerce and in the merchant account. Payment availability and customer approval are handled by Zip, while your Commerce checkout handles the order and its result pages.
