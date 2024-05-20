<?php

class Produk {
    private $nama;
    private $harga;

    public function __construct($nama, $harga) {
        $this->nama = $nama;
        $this->harga = $harga;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getHarga() {
        return $this->harga;
    }
}

class ItemKeranjang {
    private $produk;
    private $kuantitas;

    public function __construct($produk, $kuantitas) {
        $this->produk = $produk;
        $this->kuantitas = $kuantitas;
    }

    public function getProduk() {
        return $this->produk;
    }

    public function getKuantitas() {
        return $this->kuantitas;
    }

    public function getTotalHarga() {
        return $this->produk->getHarga() * $this->kuantitas;
    }
}

class Keranjang {
    private $item = [];

    public function tambahItem($produk, $kuantitas) {
        $this->item[] = new ItemKeranjang($produk, $kuantitas);
    }

    public function getItem() {
        return $this->item;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->item as $item) {
            $total += $item->getTotalHarga();
        }
        return $total;
    }
}

class Kasir {
    private $keranjang;

    public function __construct($keranjang) {
        $this->keranjang = $keranjang;
    }

    public function bayar() {
        $total = $this->keranjang->getTotal();
        echo "<p>Total yang harus dibayar adalah: Rp" . number_format($total, 2) . "</p>";
        $this->cetakStruk();
    }

    public function cetakStruk() {
        $item = $this->keranjang->getItem();
        echo "<h2>STRUK PEMBELIAN</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nama Produk</th>";
        echo "<th>Kuantitas</th>";
        echo "<th>Harga Satuan</th>";
        echo "<th>Total Harga</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($item as $itemDetail) {
            echo "<tr>";
            echo "<td>" . $itemDetail->getProduk()->getNama() . "</td>";
            echo "<td>" . $itemDetail->getKuantitas() . "</td>";
            echo "<td>Rp" . number_format($itemDetail->getProduk()->getHarga(), 2) . "</td>";
            echo "<td>Rp" . number_format($itemDetail->getTotalHarga(), 2) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "<p>Total Pembayaran: Rp" . number_format($this->keranjang->getTotal(), 2) . "</p>";
        echo "<p>Terima Kasih!</p>";
    }
}

// Proses form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaProduk = $_POST['namaProduk'];
    $hargaProduk = floatval($_POST['hargaProduk']);
    $kuantitas = intval($_POST['kuantitas']);

    $produk = new Produk($namaProduk, $hargaProduk);
    $keranjang = new Keranjang();
    $keranjang->tambahItem($produk, $kuantitas);

    $kasir = new Kasir($keranjang);
    $kasir->bayar();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Toko</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Kasir Toko</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="namaProduk">Nama Produk:</label>
                <input type="text" class="form-control" id="namaProduk" name="namaProduk" required>
            </div>
            <div class="form-group">
                <label for="hargaProduk">Harga Produk (Rp):</label>
                <input type="text" class="form-control" id="hargaProduk" name="hargaProduk" required>
            </div>
            <div class="form-group">
                <label for="kuantitas">Kuantitas:</label>
                <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</body>
</html>
