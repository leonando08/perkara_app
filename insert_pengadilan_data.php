<?php
// Script untuk mengisi data pengadilan sesuai gambar
// Data Pengadilan Negeri di Kalimantan Selatan

echo "<h1>Insert Data Pengadilan</h1>";
echo "<p>Mengisi data pengadilan sesuai dengan list yang diberikan...</p>";

try {
    // Database config
    $host = 'db';
    $username = 'perkara_user';
    $password = 'perkara_pass';
    $database = 'perkara_db';
    $port = 3306;

    // Connect to MySQL
    echo "<h2>1. Connecting to Database...</h2>";
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>✅ Connected to database</p>";

    // Data pengadilan sesuai gambar yang diberikan
    $pengadilan_data = [
        ['kode' => 'PN-BANJARMASIN', 'nama_pengadilan' => 'Pengadilan Negeri Banjarmasin'],
        ['kode' => 'PN-KANDANGAN', 'nama_pengadilan' => 'Pengadilan Negeri Kandangan'],
        ['kode' => 'PN-MARTAPURA', 'nama_pengadilan' => 'Pengadilan Negeri Martapura'],
        ['kode' => 'PN-KOTABARU', 'nama_pengadilan' => 'Pengadilan Negeri Kotabaru'],
        ['kode' => 'PN-BARABAI', 'nama_pengadilan' => 'Pengadilan Negeri Barabai'],
        ['kode' => 'PN-AMUNTAI', 'nama_pengadilan' => 'Pengadilan Negeri Amuntai'],
        ['kode' => 'PN-TANJUNG', 'nama_pengadilan' => 'Pengadilan Negeri Tanjung'],
        ['kode' => 'PN-RANTAU', 'nama_pengadilan' => 'Pengadilan Negeri Rantau'],
        ['kode' => 'PN-PELAIHARI', 'nama_pengadilan' => 'Pengadilan Negeri Pelaihari'],
        ['kode' => 'PN-MARABAHAN', 'nama_pengadilan' => 'Pengadilan Negeri Marabahan'],
        ['kode' => 'PN-BANJARBARU', 'nama_pengadilan' => 'Pengadilan Negeri Banjarbaru'],
        ['kode' => 'PN-BATULICIN', 'nama_pengadilan' => 'Pengadilan Negeri Batulicin'],
        ['kode' => 'PN-PARINGIN', 'nama_pengadilan' => 'Pengadilan Negeri Paringin']
    ];

    // Clear existing data (optional)
    echo "<h2>2. Clearing existing pengadilan data...</h2>";
    $pdo->exec("DELETE FROM pengadilan");
    echo "<p>✅ Existing data cleared</p>";

    // Reset auto increment
    $pdo->exec("ALTER TABLE pengadilan AUTO_INCREMENT = 1");

    // Insert new data
    echo "<h2>3. Inserting pengadilan data...</h2>";
    $stmt = $pdo->prepare("INSERT INTO pengadilan (kode, nama_pengadilan, created_at) VALUES (?, ?, NOW())");

    $count = 0;
    foreach ($pengadilan_data as $pengadilan) {
        try {
            $stmt->execute([$pengadilan['kode'], $pengadilan['nama_pengadilan']]);
            $count++;
            echo "<p>✅ {$count}. {$pengadilan['nama_pengadilan']}</p>";
        } catch (Exception $e) {
            echo "<p>❌ Error inserting {$pengadilan['nama_pengadilan']}: " . $e->getMessage() . "</p>";
        }
    }

    echo "<h2>4. Verification - Current pengadilan data:</h2>";
    $stmt = $pdo->query("SELECT id, kode, nama_pengadilan FROM pengadilan ORDER BY nama_pengadilan ASC");

    if ($stmt->rowCount() > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f2f2f2;'><th>ID</th><th>Kode</th><th>Nama Pengadilan</th></tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['kode']}</td>";
            echo "<td>{$row['nama_pengadilan']}</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<p><strong>Total: {$stmt->rowCount()} pengadilan berhasil diinsert</strong></p>";
    } else {
        echo "<p>❌ No data found</p>";
    }

    echo "<h2>✅ Data pengadilan berhasil diupdate!</h2>";
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>Summary:</h3>";
    echo "<ul>";
    echo "<li>✅ Total {$count} Pengadilan Negeri di Kalimantan Selatan</li>";
    echo "<li>✅ Data sesuai dengan gambar yang diberikan</li>";
    echo "<li>✅ Kode pengadilan menggunakan format PN-[NAMA]</li>";
    echo "<li>✅ Siap untuk digunakan di form registrasi</li>";
    echo "</ul>";
    echo "</div>";

    echo "<div style='text-align: center; margin-top: 30px;'>";
    echo "<a href='index.php/auth_simple/register' style='background:#28a745;color:white;padding:12px 24px;text-decoration:none;border-radius:5px;font-weight:bold;'>Test Registration Form</a> ";
    echo "<a href='index.php/auth_simple/login' style='background:#007bff;color:white;padding:12px 24px;text-decoration:none;border-radius:5px;font-weight:bold;margin-left:10px;'>Go to Login</a>";
    echo "</div>";
} catch (Exception $e) {
    echo "<h2>❌ Database Error:</h2>";
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;'>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Please check:</strong><br>";
    echo "- Docker containers are running<br>";
    echo "- Database connection settings<br>";
    echo "- Pengadilan table exists<br>";
    echo "</div>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f8f9fa;
    }

    table {
        border-collapse: collapse;
        margin: 20px 0;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    h1,
    h2 {
        color: #333;
    }
</style>