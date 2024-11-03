<script>
    document.addEventListener("DOMContentLoaded", function() {
        const administracjaDiv = document.getElementById("administracja");
        let rozwiniete = false;

        administracjaDiv.onclick = function() {
            if (!rozwiniete) {
                administracjaDiv.style.width = "90%";
                administracjaDiv.style.height = "30vh";
                administracjaDiv.style.left = "5%";
            } else {
                administracjaDiv.style.width = "100px";
                administracjaDiv.style.height = "35px";
                administracjaDiv.style.left = "50%";
            }
            rozwiniete = !rozwiniete;
        };
    });
</script>
