const $form = $("#frmRegistroClave");
const $pass = $("#clave");
const $pass2 = $("#clave1");
const $msg = $("#msgClave");
const $msg2 = $("#msgClave1");
const $req = $("#reqClave");
const $bar = $("#barClave");

const $btnGuardar = $("#btnGuardarClave").length ? $("#btnGuardarClave") : $form.find('button[type="submit"], input[type="submit"]').first();

const RULES = [
    { re: /.{6,}/, label: "mínimo 6 caracteres" },
    { re: /[A-Z]/, label: "al menos una mayúscula" },
    { re: /[a-z]/, label: "al menos una minúscula" },
    { re: /\d/, label: "al menos un número" }
];


function evaluatePassword(pwd) {
    const passed = RULES.filter(r => r.re.test(pwd));
    const missing = RULES.filter(r => !r.re.test(pwd)).map(r => r.label);
    const score = passed.length; // 0..4
    return { score, missing };
}

function paintStrength(score, missing) {
    const pct = (score / RULES.length) * 100;
    $bar.css("width", pct + "%");

    $bar.removeClass("bg-danger bg-warning bg-success");
    let label, colorClass, txt;

    if (score <= 1) {
        label = "No segura";
        colorClass = "bg-danger";
    } else if (score === 2 || score === 3) {
        label = "Aceptable";
        colorClass = "bg-warning";
    } else {
        label = "Segura";
        colorClass = "bg-success";
    }
    $bar.addClass(colorClass);

    if (score === RULES.length) {
        $msg.text("Contraseña segura ✔").css("color", "green");
        $pass.removeClass("is-invalid").addClass("is-valid");
        $req.text("");
    } else {
        $msg.text(label).css("color", "red");
        $pass.removeClass("is-valid").addClass("is-invalid");
        $req.html("Falta: " + missing.join(", "));
    }
}

function checkMatch() {
    const a = $pass.val();
    const b = $pass2.val();
    if (b.length === 0) {
        $msg2.text("");
        $pass2.removeClass("is-valid is-invalid");
        return false;
    }
    if (a === b) {
        $msg2.text("Las contraseñas coinciden ✔").css("color", "green");
        $pass2.removeClass("is-invalid").addClass("is-valid");
        return true;
    } else {
        $msg2.text("Las contraseñas no coinciden ❌").css("color", "red");
        $pass2.removeClass("is-valid").addClass("is-invalid");
        return false;
    }
}

function puedeGuardar() {
    const { score, missing } = evaluatePassword($pass.val());
    paintStrength(score, missing);
    const okMatch = checkMatch();
    const ok = score === RULES.length && okMatch;
    if ($btnGuardar.length) $btnGuardar.prop("disabled", !ok);
    return ok;
}

$pass.on("input", puedeGuardar);
$pass2.on("input", puedeGuardar);

$(function () {
    puedeGuardar();
});

function validarClaveAntesDeGuardar() {
    const { score, missing } = evaluatePassword($pass.val());
    if (score !== RULES.length) {
        swalError("La contraseña no es suficientemente segura. Falta: " + missing.join(", "));
        $pass.trigger("focus");
        return false;
    }
    if (!checkMatch()) {
        swalError("Las contraseñas no coinciden.");
        $pass2.trigger("focus");
        return false;
    }
    return true;
}

function mostrarCuentaRegresiva(url, segundos = 5) {
    let restante = segundos;
    let intervalo;

    Swal.fire({
        icon: 'success',
        title: 'Clave actualizada',
        html: 'Su sesión se cerrará en <b id="swalCuenta">' + restante + '</b> segundos...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        timer: (segundos + 1) * 1000, // +1 para que se alcance a ver el 0
        timerProgressBar: true,
        didOpen: () => {
            const $cuenta = Swal.getPopup().querySelector('#swalCuenta');
            intervalo = setInterval(() => {
                restante = Math.max(restante - 1, 0);
                $cuenta.textContent = restante;
            }, 1000);
        },
        willClose: () => clearInterval(intervalo)
    }).then(() => {
        redireccionar(url);
    });
}

function fn_guardarClave() {
    if (!validarClaveAntesDeGuardar()) return;
    alertaMensaje("¿Desea Cambiar su Clave?", function () {
        var str = $form.serialize();
        ajax('seguridad/perfil_user_update', str)
            .then(function (data) {
                if (data.error || typeof data !== 'object') {
                    throw data?.message || data;
                }
                mostrarCuentaRegresiva(data.url, 5);
            })
            .catch(function (err) {
                swalError(err);
            });
    });
}
/************************************   subir foto  */


function fn_subirArchivo() {
    swalProcesando();
    var str_files = new FormData($('#frmSubirArchivo')[0]);

    ajaxArchivo(str_files, "seguridad/perfil_subir_foto")
        .then(function (data) {
            Swal.close();
            var ok = (data === "0" || data === 0 || (data && data.ok === true));
            var msg = (data && data.mensaje) ? data.mensaje
                : (typeof data === 'string' ? data : 'Ocurrió un error.');

            if (ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Foto actualizada',
                    text: 'La imagen se subió correctamente.',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                }).then(() => recargar(750, 'O'));
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'No se pudo subir la foto',
                    text: msg,
                    confirmButtonText: 'Cerrar'
                });
            }
        })
        .catch(function (err) {
            Swal.close();
            var msg = (err && err.mensaje) || (err && err.message) || 'Error inesperado.';
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg,
                confirmButtonText: 'Cerrar'
            });
        });
}
