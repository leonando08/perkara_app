<?php
class Perkara
{
    private $conn;
    private $table = "perkara_banding";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id ASC";
        return $this->conn->query($sql);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        if (!$stmt) {
            die("Error prepare getById: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getFiltered($filters)
    {
        $query = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        $types  = "";

        if (!empty($filters['bulan'])) {
            $query .= " AND DATE_FORMAT(tgl_register_banding, '%Y-%m') = ?";
            $types  .= "s";
            $params[] = $filters['bulan'];
        }

        if (!empty($filters['asal_pengadilan'])) {
            $query .= " AND asal_pengadilan LIKE ?";
            $types  .= "s";
            $params[] = "%" . $filters['asal_pengadilan'] . "%";
        }

        if (!empty($filters['klasifikasi'])) {
            $query .= " AND klasifikasi LIKE ?";
            $types  .= "s";
            $params[] = "%" . $filters['klasifikasi'] . "%";
        }

        if (!empty($filters['status'])) {
            $query .= " AND status_perkara_tk_banding LIKE ?";
            $types  .= "s";
            $params[] = "%" . $filters['status'] . "%";
        }

        $stmt = $this->conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }


    public function add($data)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} 
        (asal_pengadilan, nomor_perkara_tk1, parent, klasifikasi, 
         tgl_register_banding, nomor_perkara_banding, lama_proses, 
         status_perkara_tk_banding, pemberitahuan_putusan_banding, 
         permohonan_kasasi, pengiriman_berkas_kasasi, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            die("Error prepare add: " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssisssssssss",  // 12 kolom = 12 parameter
            $data['asal_pengadilan'],
            $data['nomor_perkara_tk1'],
            $data['parent'],                // INT (parent_id)
            $data['klasifikasi'],           // nama (string)
            $data['tgl_register_banding'],
            $data['nomor_perkara_banding'],
            $data['lama_proses'],
            $data['status_perkara_tk_banding'],
            $data['pemberitahuan_putusan_banding'],
            $data['permohonan_kasasi'],
            $data['pengiriman_berkas_kasasi'],
            $data['status']
        );

        return $stmt->execute();
    }


    public function searchByPengadilan($keyword)
    {
        $keyword = "%$keyword%";
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE asal_pengadilan LIKE ? ORDER BY id ASC");
        if (!$stmt) {
            die("Error prepare searchByPengadilan: " . $this->conn->error);
        }
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getByMonth($bulan)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE DATE_FORMAT(tgl_register_banding, '%Y-%m') = ?");
        if (!$stmt) {
            die("Error prepare getByMonth: " . $this->conn->error);
        }
        $stmt->bind_param("s", $bulan);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function update($id, $data)
    {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET 
            asal_pengadilan = ?, 
            nomor_perkara_tk1 = ?, 
            parent = ?, 
            klasifikasi = ?, 
            tgl_register_banding = ?, 
            nomor_perkara_banding = ?, 
            lama_proses = ?, 
            status_perkara_tk_banding = ?, 
            pemberitahuan_putusan_banding = ?, 
            permohonan_kasasi = ?, 
            pengiriman_berkas_kasasi = ?, 
            status = ?
        WHERE id = ?"
        );

        if (!$stmt) {
            die("Error prepare update: " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssisssssssssi",  // ada 13 kolom + id = 14 parameter
            $data['asal_pengadilan'],
            $data['nomor_perkara_tk1'],
            $data['parent'],                // angka (INT)
            $data['klasifikasi'],           // nama (VARCHAR)
            $data['tgl_register_banding'],
            $data['nomor_perkara_banding'],
            $data['lama_proses'],
            $data['status_perkara_tk_banding'],
            $data['pemberitahuan_putusan_banding'],
            $data['permohonan_kasasi'],
            $data['pengiriman_berkas_kasasi'],
            $data['status'],
            $id
        );

        return $stmt->execute();
    }


    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        if (!$stmt) {
            die("Error prepare delete: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
