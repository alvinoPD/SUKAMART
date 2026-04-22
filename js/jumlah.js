let hargaAwal = harga;
let nilai = 1;

function update(){
    document.getElementById("angka").innerHTML = nilai;

    let total = hargaAwal * nilai;

    document.getElementById("total").innerHTML = "Rp " + total;

    document.getElementById("jumlahInput").value = nilai;
}

function tambah(){
    nilai++;
    update();
}

function kurang(){
    if (nilai > 1) {
        nilai--;
        update();
    }
}

update(); // ini penting
