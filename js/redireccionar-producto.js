function redireccionar(id) {
    var url = "producto";
    url += "?id=" + encodeURIComponent(id);
    window.location.href = url;
  }