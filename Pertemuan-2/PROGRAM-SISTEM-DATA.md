# LAPORAN PROGRAM SISTEM DATA MAHASISWA

**Pertemuan:** 2  
**Tugas:** Program Sistem Data Mahasiswa 

---

## 1. Latar Belakang

Dalam pengembangan perangkat lunak, pengelolaan data merupakan salah satu fungsi dasar yang banyak digunakan dalam berbagai aplikasi. Salah satu contoh sederhana adalah sistem pengelolaan data mahasiswa yang dapat digunakan untuk menyimpan, menampilkan, mencari, dan menghapus informasi mahasiswa.

Pada tugas ini dibuat sebuah **Program Sistem Data Mahasiswa** menggunakan bahasa pemrograman **C#** dengan platform **.NET** dalam bentuk aplikasi console. Program dibuat menggunakan Visual Studio dan menerapkan konsep dasar pemrograman seperti class, object, property, constructor, method, collection, percabangan, perulangan, dan validasi input.

Program memiliki beberapa fungsi utama, yaitu:

1. Menambahkan data mahasiswa.
2. Menampilkan seluruh data mahasiswa.
3. Mencari mahasiswa berdasarkan NIM.
4. Menghapus data mahasiswa.
5. Keluar dari aplikasi.

Setiap data mahasiswa memiliki informasi berupa NIM, nama, program studi, dan IPK. Data mahasiswa disimpan sementara menggunakan `List<Mahasiswa>` selama program berjalan.

---

## 2. Alasan Menggunakan .NET

.NET merupakan platform pengembangan perangkat lunak dari Microsoft yang dapat digunakan untuk membangun berbagai jenis aplikasi dengan bahasa pemrograman seperti C#. Pada program ini, .NET digunakan karena memiliki beberapa keunggulan.

### 2.1 Mendukung Bahasa C#

C# merupakan salah satu bahasa utama yang digunakan pada .NET. C# memiliki sintaks yang terstruktur dan mendukung konsep **Object-Oriented Programming (OOP)**. Pada program Sistem Data Mahasiswa, konsep OOP diterapkan melalui class `Mahasiswa`.

```csharp
class Mahasiswa
{
    public string NIM { get; set; }
    public string Nama { get; set; }
    public string Prodi { get; set; }
    public double IPK { get; set; }
}
```

Class tersebut digunakan sebagai blueprint untuk membentuk object mahasiswa.

### 2.2 Memiliki Library yang Lengkap

.NET menyediakan banyak library bawaan yang dapat digunakan secara langsung. Pada program ini digunakan:

```csharp
using System;
using System.Collections.Generic;
using System.Text;
```

`System` digunakan untuk fungsi dasar seperti `Console.WriteLine()` dan `Console.ReadLine()`, sedangkan `System.Collections.Generic` digunakan untuk menyediakan struktur data seperti `List<Mahasiswa>`. Dengan library tersebut, programmer tidak perlu membuat seluruh fitur dasar dari awal.

### 2.3 Mendukung Object-Oriented Programming

.NET dan C# mendukung pemrograman berbasis object. Pada program ini, data mahasiswa direpresentasikan melalui object dari class `Mahasiswa`.

```csharp
Mahasiswa mahasiswa = new Mahasiswa(
    nim,
    nama,
    prodi,
    ipk
);
```

Pendekatan ini membuat kode lebih terstruktur, lebih mudah dipahami, dan lebih mudah dikembangkan.

### 2.4 Automatic Memory Management

.NET memiliki sistem pengelolaan memori otomatis melalui **Garbage Collector (GC)**. Garbage Collector membantu mengelola object yang sudah tidak digunakan sehingga programmer tidak perlu mengatur memori secara manual.

### 2.5 Integrasi dengan Visual Studio

.NET memiliki integrasi yang sangat baik dengan Visual Studio. Visual Studio menyediakan berbagai fitur yang membantu proses pengembangan seperti IntelliSense, debugging, error detection, project dan solution management, build dan run program, serta NuGet Package Manager.

### 2.6 Dapat Dikembangkan ke Berbagai Jenis Aplikasi

Program yang dibuat menggunakan .NET dapat dikembangkan lebih lanjut menjadi berbagai bentuk aplikasi seperti Console Application, Desktop Application, Web Application, Web API, dan Cloud Application. Dengan demikian, Sistem Data Mahasiswa yang saat ini masih berupa aplikasi console dapat dikembangkan menjadi aplikasi yang lebih kompleks di masa mendatang.

> **Catatan:** Pada Visual Studio versi terbaru, project biasanya menggunakan .NET modern. Istilah `.NET Framework` secara khusus merujuk pada implementasi .NET yang lebih lama dan terutama digunakan pada Windows.

---

## 3. Penjelasan Implementasi

Program terdiri dari dua class utama, yaitu `Mahasiswa` dan `Program`.

Struktur sederhananya adalah:

```text
DataMahasiswa
│
├── Mahasiswa
│   ├── NIM
│   ├── Nama
│   ├── Prodi
│   └── IPK
│
└── Program
    ├── Main()
    ├── TampilkanMenu()
    ├── TambahMahasiswa()
    ├── TampilkanMahasiswa()
    ├── CariMahasiswa()
    ├── HapusMahasiswa()
    └── Judul()
```

---

## 4. Class `Mahasiswa`

Class `Mahasiswa` digunakan untuk merepresentasikan satu data mahasiswa.

```csharp
class Mahasiswa
{
    public string NIM { get; set; }
    public string Nama { get; set; }
    public string Prodi { get; set; }
    public double IPK { get; set; }

    public Mahasiswa(string nim, string nama, string prodi, double ipk)
    {
        NIM = nim;
        Nama = nama;
        Prodi = prodi;
        IPK = ipk;
    }
}
```

Property `NIM` digunakan untuk menyimpan Nomor Induk Mahasiswa, `Nama` untuk menyimpan nama mahasiswa, `Prodi` untuk menyimpan program studi, dan `IPK` untuk menyimpan nilai indeks prestasi kumulatif. Tipe data `double` digunakan pada IPK karena nilainya dapat berupa angka desimal.

---

## 5. Constructor `Mahasiswa`

Constructor digunakan untuk memberikan nilai awal ketika object mahasiswa dibuat.

```csharp
public Mahasiswa(string nim, string nama, string prodi, double ipk)
{
    NIM = nim;
    Nama = nama;
    Prodi = prodi;
    IPK = ipk;
}
```

Contoh pembuatan object:

```csharp
Mahasiswa mahasiswa = new Mahasiswa(
    "5025231280",
    "Ananda Faris",
    "Informatika",
    3.75
);
```

Object tersebut menyimpan data mahasiswa berupa NIM, nama, program studi, dan IPK.

---

## 6. `List<Mahasiswa>`

Program menggunakan:

```csharp
static List<Mahasiswa> daftarMahasiswa = new List<Mahasiswa>();
```

`List<Mahasiswa>` digunakan untuk menyimpan banyak object mahasiswa. Data pada `List` hanya disimpan selama program berjalan. Jika aplikasi ditutup, data akan hilang karena program belum menggunakan file atau database sebagai penyimpanan permanen.

---

## 7. Fungsi `Main()`

```csharp
static void Main(string[] args)
```

`Main()` merupakan titik awal eksekusi program. Pada fungsi ini digunakan perulangan `do-while` agar program terus menampilkan menu sampai pengguna memilih opsi keluar.

```csharp
do
{
    TampilkanMenu();

    ...

} while (pilihan != 5);
```

Program juga menggunakan `switch (pilihan)` untuk menentukan fungsi yang harus dijalankan berdasarkan pilihan pengguna.

```text
Pilihan 1 -> TambahMahasiswa()
Pilihan 2 -> TampilkanMahasiswa()
Pilihan 3 -> CariMahasiswa()
Pilihan 4 -> HapusMahasiswa()
Pilihan 5 -> Keluar
```

Jika pengguna memasukkan pilihan selain `1` sampai `5`, program akan menampilkan pesan bahwa pilihan tidak tersedia.

---

## 8. Fungsi `TampilkanMenu()`

```csharp
static void TampilkanMenu()
```

Fungsi ini digunakan untuk menampilkan menu utama aplikasi, yaitu Tambah Mahasiswa, Tampilkan Mahasiswa, Cari Mahasiswa, Hapus Mahasiswa, dan Keluar.

Di awal fungsi terdapat:

```csharp
Console.Clear();
```

Perintah tersebut digunakan untuk membersihkan tampilan console sebelum menu ditampilkan kembali. Program juga menggunakan `Console.ForegroundColor` untuk memberikan warna pada beberapa bagian menu agar tampilannya lebih menarik dan mudah dibaca.

---

## 9. Fungsi `TambahMahasiswa()`

```csharp
static void TambahMahasiswa()
```

Fungsi ini digunakan untuk menambahkan data mahasiswa baru. Pengguna diminta memasukkan NIM, nama, program studi, dan IPK.

Setelah semua data dimasukkan, program membuat object baru:

```csharp
Mahasiswa mahasiswa = new Mahasiswa(
    nim,
    nama,
    prodi,
    ipk
);
```

Kemudian object tersebut dimasukkan ke dalam list:

```csharp
daftarMahasiswa.Add(mahasiswa);
```

Program juga melakukan validasi NIM untuk mencegah data mahasiswa dengan NIM yang sama dimasukkan lebih dari satu kali.

```csharp
foreach (Mahasiswa m in daftarMahasiswa)
{
    if (m.NIM.Equals(nim, StringComparison.OrdinalIgnoreCase))
    {
        Console.WriteLine("NIM tersebut sudah terdaftar!");
        return;
    }
}
```

Selain itu, IPK divalidasi menggunakan `double.TryParse()` agar input harus berupa angka dengan rentang `0` sampai `4`.

---

## 10. Fungsi `TampilkanMahasiswa()`

```csharp
static void TampilkanMahasiswa()
```

Fungsi ini digunakan untuk menampilkan seluruh data mahasiswa yang tersimpan.

Program terlebih dahulu mengecek apakah list masih kosong:

```csharp
if (daftarMahasiswa.Count == 0)
```

Jika list kosong, program menampilkan pesan `Belum ada data mahasiswa.`. Jika data tersedia, program menggunakan `foreach` untuk membaca setiap object mahasiswa satu per satu.

```csharp
foreach (Mahasiswa m in daftarMahasiswa)
```

Data kemudian ditampilkan dalam bentuk tabel yang berisi NIM, nama, program studi, dan IPK. Program juga menampilkan jumlah mahasiswa dengan menggunakan `daftarMahasiswa.Count`.

---

## 11. Fungsi `CariMahasiswa()`

```csharp
static void CariMahasiswa()
```

Fungsi ini digunakan untuk mencari mahasiswa berdasarkan NIM. Pengguna memasukkan NIM mahasiswa yang ingin dicari, kemudian program memeriksa seluruh data di dalam `daftarMahasiswa`.

```csharp
foreach (Mahasiswa m in daftarMahasiswa)
```

NIM dibandingkan menggunakan:

```csharp
m.NIM.Equals(
    nimCari,
    StringComparison.OrdinalIgnoreCase
)
```

Jika mahasiswa ditemukan, program menampilkan NIM, nama, program studi, dan IPK mahasiswa tersebut. Jika tidak ditemukan, program menampilkan pesan bahwa mahasiswa dengan NIM tersebut tidak ditemukan.

---

## 12. Fungsi `HapusMahasiswa()`

```csharp
static void HapusMahasiswa()
```

Fungsi ini digunakan untuk menghapus data mahasiswa berdasarkan NIM. Program terlebih dahulu mencari mahasiswa dengan NIM yang dimasukkan oleh pengguna.

Jika mahasiswa ditemukan, program menampilkan data mahasiswa tersebut dan meminta konfirmasi:

```text
Yakin ingin menghapus data? (y/n):
```

Jika pengguna memasukkan `y`, data akan dihapus menggunakan:

```csharp
daftarMahasiswa.Remove(mahasiswaDitemukan);
```

Jika pengguna memilih selain `y`, proses penghapusan dibatalkan. Konfirmasi ini berguna untuk mengurangi kemungkinan data terhapus secara tidak sengaja.

---

## 13. Fungsi `Judul()`

```csharp
static void Judul(string teks)
```

Fungsi `Judul()` merupakan fungsi tambahan untuk menampilkan judul halaman secara konsisten.

Contoh:

```csharp
Judul("TAMBAH MAHASISWA");
```

akan menghasilkan tampilan seperti:

```text
====================================================
 TAMBAH MAHASISWA
====================================================
```

Dengan menggunakan fungsi ini, program tidak perlu menuliskan kode tampilan judul yang sama secara berulang pada setiap menu.

---

## 14. Alur Kerja Program

Secara umum, alur kerja program adalah sebagai berikut:

```text
Program dimulai
       |
       v
Tampilkan Menu
       |
       v
Pengguna memilih menu
       |
       +-------------------------------+
       |                               |
       v                               v
1 -> Tambah Mahasiswa          2 -> Tampilkan Mahasiswa
3 -> Cari Mahasiswa            4 -> Hapus Mahasiswa
5 -> Keluar
       |
       v
Kembali ke menu
       |
       v
Apakah pilihan = 5?
       |
   +---+---+
   |       |
 Tidak     Ya
   |       |
   v       v
Menu     Program selesai
lagi
```

---

## 15. Konsep Pemrograman yang Digunakan

Program Sistem Data Mahasiswa menggunakan beberapa konsep dasar pemrograman C#.

- **Class dan Object** digunakan untuk merepresentasikan data mahasiswa.
- **Property** digunakan untuk menyimpan atribut NIM, nama, program studi, dan IPK.
- **Constructor** digunakan untuk memberikan nilai awal pada object mahasiswa.
- **Collection** berupa `List<Mahasiswa>` digunakan untuk menyimpan banyak object mahasiswa.
- **Percabangan** menggunakan `if`, `else`, dan `switch` untuk menentukan proses berdasarkan kondisi.
- **Perulangan** menggunakan `do-while`, `while`, dan `foreach` untuk menjalankan proses secara berulang.
- **Method** digunakan untuk membagi program menjadi beberapa fungsi dengan tanggung jawab yang berbeda.

Method utama yang digunakan adalah:

```text
Main()
TampilkanMenu()
TambahMahasiswa()
TampilkanMahasiswa()
CariMahasiswa()
HapusMahasiswa()
Judul()
```

---

## 16. Kelebihan Program

Program memiliki beberapa kelebihan, yaitu:

1. Struktur program sederhana dan mudah dipahami.
2. Menggunakan konsep Object-Oriented Programming.
3. Menggunakan `List` untuk menyimpan banyak data mahasiswa.
4. Memiliki validasi nilai IPK.
5. Mencegah NIM yang sama ditambahkan lebih dari sekali.
6. Memiliki fungsi pencarian berdasarkan NIM.
7. Memiliki konfirmasi sebelum data dihapus.
8. Tampilan console menggunakan warna.
9. Setiap proses utama dipisahkan ke dalam fungsi yang berbeda sehingga program lebih terorganisasi.

---

## 17. Kekurangan Program

Program masih memiliki beberapa keterbatasan. Data mahasiswa hanya disimpan di dalam `List<Mahasiswa>`, sehingga data masih berada di memori sementara dan akan hilang ketika aplikasi ditutup.

Program juga belum memiliki beberapa fitur seperti:

- Edit data mahasiswa.
- Penyimpanan permanen.
- Database.
- Login.
- Sorting data.
- Pencarian berdasarkan nama.
- Graphical User Interface.

---

## 18. Pengembangan Selanjutnya

Program dapat dikembangkan lebih lanjut dengan menambahkan:

1. Penyimpanan data ke file JSON atau CSV.
2. Penggunaan database seperti SQL Server atau MySQL.
3. Fitur edit data mahasiswa.
4. Pencarian berdasarkan nama atau program studi.
5. Pengurutan mahasiswa berdasarkan NIM, nama, atau IPK.
6. GUI menggunakan Windows Forms atau WPF.
7. Pengembangan menjadi web application menggunakan ASP.NET Core.

---

## 19. Kesimpulan

Program Sistem Data Mahasiswa merupakan aplikasi console sederhana yang dibuat menggunakan C# dan .NET untuk mengelola data mahasiswa. Program memiliki fungsi utama untuk menambahkan mahasiswa, menampilkan seluruh data mahasiswa, mencari mahasiswa berdasarkan NIM, menghapus mahasiswa, dan keluar dari aplikasi.

Data mahasiswa direpresentasikan menggunakan class `Mahasiswa` dan disimpan sementara menggunakan `List<Mahasiswa>`. Melalui pembuatan program ini dapat dipelajari konsep dasar pemrograman C# seperti **class, object, property, constructor, List, method, percabangan, perulangan, dan validasi input**.

Penggunaan .NET memberikan keuntungan berupa dukungan yang baik terhadap C#, library yang lengkap, pengelolaan memori otomatis, integrasi dengan Visual Studio, serta kemampuan untuk mengembangkan program menjadi aplikasi yang lebih kompleks.
