function redireccionarCheckout(id) {
    var url = "checkout";
    url += "?id=" + encodeURIComponent(id);
    window.location.href = url;
}