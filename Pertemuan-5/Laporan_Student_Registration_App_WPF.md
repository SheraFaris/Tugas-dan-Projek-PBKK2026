# LAPORAN PROGRAM STUDENT REGISTRATION APP DENGAN WPF

## Identitas

**Nama:** Ananda Faris GR  
**NRP:** 5025231280  
**Pertemuan:** [Isi sesuai pertemuan praktikum]  
**Tugas:** Program Student Registration App dengan WPF  

---

## 1. Latar Belakang

Pendaftaran mahasiswa adalah contoh proses pengelolaan informasi yang dapat diimplementasikan melalui aplikasi desktop. Pengguna perlu memasukkan identitas mahasiswa, memilih program studi dan jenis kelamin, kemudian melihat data yang telah didaftarkan. Penggunaan **Graphical User Interface (GUI)** memungkinkan pengguna berinteraksi melalui formulir dan tombol tanpa harus mengetik perintah pada terminal.

Pada tugas ini dikembangkan **Student Registration App** menggunakan bahasa pemrograman **C#** dan **Windows Presentation Foundation (WPF)**. Aplikasi menggunakan **XAML** untuk mendefinisikan tampilan dan **C#** untuk menjalankan logika aplikasi, seperti validasi input, penyimpanan sementara, reset formulir, serta penghapusan data.

Fitur utama aplikasi meliputi:

1. Mengisi NIM dan nama mahasiswa.
2. Memilih program studi dan jenis kelamin.
3. Menyimpan data mahasiswa melalui tombol **Simpan**.
4. Menampilkan daftar mahasiswa yang sudah didaftarkan.
5. Mengosongkan formulir melalui tombol **Reset**.
6. Menghapus mahasiswa terpilih setelah konfirmasi.
7. Menampilkan jumlah mahasiswa terdaftar.

Data disimpan sementara selama aplikasi berjalan menggunakan `ObservableCollection<Mahasiswa>`. Program **belum menggunakan database atau penyimpanan permanen**, sehingga data akan hilang ketika aplikasi ditutup.

---

## 2. Alasan Menggunakan .NET dan WPF

.NET adalah platform pengembangan aplikasi yang mendukung bahasa C# beserta berbagai pustaka untuk pembangunan perangkat lunak. WPF adalah framework GUI untuk membuat aplikasi desktop Windows menggunakan XAML dan kode C#.

### 2.1 Mendukung Bahasa C#

C# memiliki sintaks yang terstruktur dan mendukung **Object-Oriented Programming (OOP)**. Dalam aplikasi ini, informasi mahasiswa direpresentasikan melalui class `Mahasiswa`, sedangkan class `MainWindow` mengelola interaksi antarmuka.

```csharp
public class Mahasiswa
{
    public string NIM { get; set; } = string.Empty;
    public string Nama { get; set; } = string.Empty;
    public string Prodi { get; set; } = string.Empty;
    public string JenisKelamin { get; set; } = string.Empty;
}
```

### 2.2 Pemisahan Antarmuka dan Logika

WPF menggunakan `MainWindow.xaml` untuk mendefinisikan tampilan dan `MainWindow.xaml.cs` untuk logika event dan pengolahan data. Pemisahan ini mempermudah pembacaan dan pengembangan kode.

### 2.3 Memiliki Library yang Lengkap

Program memanfaatkan library .NET, di antaranya:

```csharp
using System.Collections.ObjectModel;
using System.Linq;
using System.Windows;
using System.Windows.Controls;
```

`System.Collections.ObjectModel` menyediakan `ObservableCollection`, `System.Linq` digunakan untuk pengecekan NIM dengan `Any()`, sedangkan `System.Windows` dan `System.Windows.Controls` menyediakan komponen serta event WPF.

### 2.4 Mendukung Event-Driven Programming

Kode program dijalankan sebagai respons terhadap aksi pengguna, misalnya ketika tombol Simpan, Reset, dan Hapus ditekan.

```xml
<Button Content="Simpan" Click="BtnSimpan_Click"/>
```

### 2.5 Pengelolaan Memori Otomatis

.NET menyediakan **Garbage Collector** untuk mengelola memori objek terkelola. Walaupun demikian, aplikasi tetap perlu menangani resource khusus secara tepat apabila kelak ditambah akses file, database, atau perangkat eksternal.

### 2.6 Integrasi dengan Visual Studio

Visual Studio mendukung pembuatan proyek WPF, penulisan XAML, IntelliSense, debugging, pengelolaan solution, serta build dan menjalankan aplikasi.

### 2.7 Target Framework Program

Proyek awal yang dibuat menggunakan konfigurasi berikut:

```xml
<TargetFramework>net8.0-windows</TargetFramework>
<UseWPF>true</UseWPF>
```

Artinya aplikasi menargetkan **.NET 8 untuk Windows** dengan WPF. Pada komputer praktikum tersedia **.NET 10 Runtime**; aplikasi .NET 8 tidak secara otomatis menggunakan runtime .NET 10. Agar berjalan, pengguna dapat memasang .NET 8 Desktop Runtime atau, jika SDK dan Visual Studio mendukung, mengubah target framework menjadi `net10.0-windows` lalu membangun ulang proyek. **Laporan ini mendokumentasikan kode proyek awal**; perubahan target framework tidak mengubah penjelasan logika aplikasi.

> **Catatan:** .NET modern (seperti .NET 8 dan .NET 10) berbeda dari .NET Framework klasik (misalnya .NET Framework 4.8), meskipun keduanya dapat digunakan untuk aplikasi WPF Windows.

---

## 3. Penjelasan Implementasi

Aplikasi dibuat menggunakan beberapa file dengan fungsi berbeda. Struktur proyeknya adalah:

```text
StudentRegistrationApp/
│
├── StudentRegistrationApp.csproj
├── App.xaml
├── App.xaml.cs
├── MainWindow.xaml
├── MainWindow.xaml.cs
├── Mahasiswa.cs
└── README.md
```

`StudentRegistrationApp.csproj` menyimpan konfigurasi proyek; `App.xaml` dan `App.xaml.cs` mengatur aplikasi; `MainWindow.xaml` menyusun tampilan; `MainWindow.xaml.cs` mengimplementasikan logika interaksi; `Mahasiswa.cs` mendefinisikan model data; dan `README.md` menyediakan petunjuk proyek.

Secara konseptual, alur aplikasinya adalah **Input XAML → Event Click → Validasi C# → Koleksi data → Tampilan ListBox**.

---

## 4. File `StudentRegistrationApp.csproj`

File `.csproj` berisi konfigurasi untuk proses build aplikasi:

```xml
<Project Sdk="Microsoft.NET.Sdk">
  <PropertyGroup>
    <OutputType>WinExe</OutputType>
    <TargetFramework>net8.0-windows</TargetFramework>
    <UseWPF>true</UseWPF>
    <Nullable>enable</Nullable>
    <ImplicitUsings>enable</ImplicitUsings>
    <AssemblyName>StudentRegistrationApp</AssemblyName>
    <RootNamespace>StudentRegistrationApp</RootNamespace>
  </PropertyGroup>
</Project>
```

- `OutputType` bernilai `WinExe` agar hasilnya merupakan aplikasi Windows berbasis GUI.
- `TargetFramework` menentukan target .NET.
- `UseWPF` mengaktifkan dukungan WPF.
- `Nullable` mengaktifkan analisis *nullable reference types*.
- `ImplicitUsings` memungkinkan beberapa namespace dasar tersedia secara implisit.
- `AssemblyName` dan `RootNamespace` menentukan nama assembly serta namespace dasar.

---

## 5. File `App.xaml` dan `App.xaml.cs`

`App.xaml` mengatur titik awal tampilan aplikasi:

```xml
<Application x:Class="StudentRegistrationApp.App"
             xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
             xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
             StartupUri="MainWindow.xaml">
    <Application.Resources />
</Application>
```

Atribut `StartupUri="MainWindow.xaml"` menyatakan bahwa jendela `MainWindow` ditampilkan ketika aplikasi dimulai.

Sementara itu, `App.xaml.cs` berisi:

```csharp
using System.Windows;

namespace StudentRegistrationApp;

public partial class App : Application
{
}
```

Class `App` mewarisi `Application`. Kata kunci `partial` memungkinkan implementasi class dipisah dengan kode hasil proses kompilasi XAML. Dalam proyek ini tidak terdapat logika tambahan pada `App.xaml.cs`.

---

## 6. File `MainWindow.xaml` — Tampilan GUI

File ini merupakan tempat desain antarmuka pengguna menggunakan **XAML (Extensible Application Markup Language)**. Komponen utama dalam aplikasi mencakup:

| Komponen | Nama / Penggunaan | Fungsi |
|---|---|---|
| `Window` | `MainWindow` | Jendela utama aplikasi. |
| `Grid` | Pembagian dua kolom utama | Mengatur area form dan daftar mahasiswa. |
| `Border` | Panel putih | Membingkai bagian formulir dan data. |
| `TextBlock` | Label field dan judul | Menampilkan teks statis/status. |
| `TextBox` | `txtNim`, `txtNama` | Memasukkan NIM dan nama. |
| `ComboBox` | `cmbProdi` | Memilih program studi. |
| `RadioButton` | `rbLaki`, `rbPerempuan` | Memilih jenis kelamin. |
| `Button` | Simpan, Reset, Hapus | Memicu event untuk operasi data. |
| `ListBox` | `lstMahasiswa` | Menampilkan data mahasiswa. |
| `ScrollViewer` | Pembungkus form | Menjaga agar form dapat digulir saat ruang terbatas. |

Contoh deklarasi input:

```xml
<TextBox x:Name="txtNim" MaxLength="25"/>
<TextBox x:Name="txtNama" MaxLength="100"/>
```

Atribut `x:Name` memungkinkan kontrol diakses oleh kode C#, sedangkan `MaxLength` membatasi panjang teks input.

### 6.1 Pemilihan Program Studi

```xml
<ComboBox x:Name="cmbProdi">
    <ComboBoxItem Content="Teknik Informatika"/>
    <ComboBoxItem Content="Sistem Informasi"/>
    <ComboBoxItem Content="Manajemen"/>
    <ComboBoxItem Content="Akuntansi"/>
</ComboBox>
```

`ComboBox` menyediakan pilihan program studi sehingga pengguna tidak perlu memasukkannya secara manual.

### 6.2 Pemilihan Jenis Kelamin

```xml
<RadioButton x:Name="rbLaki"
             Content="Laki-laki" GroupName="JenisKelamin"/>
<RadioButton x:Name="rbPerempuan"
             Content="Perempuan" GroupName="JenisKelamin"/>
```

Kedua `RadioButton` memiliki `GroupName` yang sama agar pengguna memilih satu opsi dalam satu kelompok.

### 6.3 Menampilkan Daftar dengan DataTemplate

```xml
<ListBox x:Name="lstMahasiswa">
    <ListBox.ItemTemplate>
        <DataTemplate>
            <StackPanel>
                <TextBlock Text="{Binding Nama}"/>
                <TextBlock Text="{Binding JenisKelamin}"/>
            </StackPanel>
        </DataTemplate>
    </ListBox.ItemTemplate>
</ListBox>
```

Cuplikan tersebut merupakan penyederhanaan dari kode proyek. `DataTemplate` menentukan susunan informasi tiap mahasiswa, dan `{Binding Nama}` mengambil nilai properti `Nama` dari objek mahasiswa yang ditampilkan. Pada implementasi lengkap juga ditampilkan NIM dan program studi.

---

## 7. Class `Mahasiswa`

Class `Mahasiswa` dalam `Mahasiswa.cs` digunakan untuk merepresentasikan satu data mahasiswa:

```csharp
namespace StudentRegistrationApp;

public class Mahasiswa
{
    public string NIM { get; set; } = string.Empty;
    public string Nama { get; set; } = string.Empty;
    public string Prodi { get; set; } = string.Empty;
    public string JenisKelamin { get; set; } = string.Empty;
}
```

- `NIM` menyimpan nomor induk mahasiswa.
- `Nama` menyimpan nama mahasiswa.
- `Prodi` menyimpan program studi.
- `JenisKelamin` menyimpan pilihan jenis kelamin.

Setiap properti bertipe `string` dengan nilai awal `string.Empty`. Objek mahasiswa dibuat menggunakan *object initializer*; class ini tidak mendeklarasikan constructor khusus, sehingga menggunakan constructor default.

---

## 8. `ObservableCollection<Mahasiswa>`

Pada `MainWindow.xaml.cs` terdapat deklarasi:

```csharp
private readonly ObservableCollection<Mahasiswa> daftarMahasiswa = new();
```

`ObservableCollection<Mahasiswa>` digunakan untuk menyimpan banyak objek mahasiswa serta mengirim notifikasi perubahan koleksi ketika item ditambahkan atau dihapus. Dengan menetapkan koleksi ini sebagai `ItemsSource` pada `ListBox`, tampilan daftar dapat ikut diperbarui saat isi koleksi berubah.

```csharp
lstMahasiswa.ItemsSource = daftarMahasiswa;
```

`readonly` mencegah field diarahkan ulang ke instance koleksi lain setelah inisialisasi, tetapi isi koleksi tetap dapat ditambah dan dihapus. Data belum disimpan ke file ataupun database.

---

## 9. Constructor `MainWindow()`

```csharp
public MainWindow()
{
    InitializeComponent();
    lstMahasiswa.ItemsSource = daftarMahasiswa;
    PerbaruiJumlah();
}
```

Constructor dipanggil saat jendela utama dibuat. Fungsinya:

1. `InitializeComponent()` memuat dan menginisialisasi komponen yang didefinisikan di XAML.
2. `ItemsSource` menghubungkan `ListBox` dengan koleksi mahasiswa.
3. `PerbaruiJumlah()` menampilkan jumlah data awal (nol saat koleksi kosong).

---

## 10. Fungsi `BtnSimpan_Click()`

```csharp
private void BtnSimpan_Click(object sender, RoutedEventArgs e)
```

Method ini merupakan **event handler** untuk tombol Simpan. Program mengambil nilai input:

```csharp
string nim = txtNim.Text.Trim();
string nama = txtNama.Text.Trim();
```

`Trim()` menghapus spasi di awal dan akhir teks. Program memvalidasi input sebelum menyimpan data, termasuk memastikan NIM dan nama terisi, program studi dipilih, jenis kelamin dipilih, serta NIM belum terdaftar.

Setelah validasi berhasil, program membuat objek:

```csharp
Mahasiswa mahasiswa = new()
{
    NIM = nim,
    Nama = nama,
    Prodi = item.Content?.ToString() ?? string.Empty,
    JenisKelamin = rbLaki.IsChecked == true ? "Laki-laki" : "Perempuan"
};
```

Kemudian data ditambahkan dan tampilan diperbarui:

```csharp
daftarMahasiswa.Add(mahasiswa);
PerbaruiJumlah();
BersihkanForm();
```

Aplikasi selanjutnya menampilkan pesan bahwa data berhasil disimpan. Dalam implementasi ini data hanya ditambahkan ke koleksi selama aplikasi berjalan.

---

## 11. Validasi Input dan NIM Duplikat

Validasi diterapkan untuk mencegah data tidak lengkap serta NIM ganda.

### 11.1 Validasi NIM dan Nama

```csharp
if (string.IsNullOrWhiteSpace(nim))
{
    MessageBox.Show("NIM harus diisi!", "Validasi",
                    MessageBoxButton.OK, MessageBoxImage.Warning);
    txtNim.Focus();
    return;
}
```

`string.IsNullOrWhiteSpace()` memeriksa apakah input kosong atau hanya berisi spasi. `Focus()` memindahkan fokus ke kontrol yang perlu diperbaiki, dan `return` menghentikan proses penyimpanan. Validasi serupa diterapkan pada nama.

### 11.2 Validasi Program Studi dan Jenis Kelamin

```csharp
if (cmbProdi.SelectedItem is not ComboBoxItem item)
{
    MessageBox.Show("Pilih program studi!");
    return;
}

if (rbLaki.IsChecked != true && rbPerempuan.IsChecked != true)
{
    MessageBox.Show("Pilih jenis kelamin!");
    return;
}
```

Bagian tersebut memastikan bahwa pengguna telah memilih kedua kategori sebelum proses dilanjutkan.

### 11.3 Validasi NIM Duplikat

```csharp
if (daftarMahasiswa.Any(m =>
    string.Equals(m.NIM, nim, System.StringComparison.OrdinalIgnoreCase)))
{
    MessageBox.Show("NIM tersebut sudah terdaftar!");
    txtNim.Focus();
    return;
}
```

Method LINQ `Any()` mengecek apakah setidaknya satu objek dalam koleksi memiliki NIM yang sama. Perbandingan `OrdinalIgnoreCase` tidak membedakan huruf besar dan kecil. Kode ini belum secara khusus memvalidasi bahwa NIM hanya terdiri atas angka.

---

## 12. Fungsi `BtnReset_Click()` dan `BersihkanForm()`

Tombol Reset menjalankan:

```csharp
private void BtnReset_Click(object sender, RoutedEventArgs e)
{
    BersihkanForm();
}
```

Method bantuan `BersihkanForm()` digunakan baik setelah penyimpanan berhasil maupun saat tombol Reset ditekan:

```csharp
private void BersihkanForm()
{
    txtNim.Clear();
    txtNama.Clear();
    cmbProdi.SelectedIndex = -1;
    rbLaki.IsChecked = false;
    rbPerempuan.IsChecked = false;
    txtNim.Focus();
}
```

Fungsi ini mengosongkan kolom NIM dan nama, menghapus pilihan program studi serta jenis kelamin, kemudian mengembalikan fokus ke kolom NIM. Reset tidak menghapus mahasiswa yang sudah tersimpan dalam daftar.

---

## 13. Fungsi `BtnHapus_Click()`

```csharp
private void BtnHapus_Click(object sender, RoutedEventArgs e)
```

Method ini menangani proses menghapus data mahasiswa yang dipilih dari `ListBox`. Program terlebih dahulu memeriksa apakah pengguna telah memilih salah satu mahasiswa:

```csharp
if (lstMahasiswa.SelectedItem is not Mahasiswa mahasiswa)
{
    MessageBox.Show("Pilih data mahasiswa yang ingin dihapus!");
    return;
}
```

Jika ada pilihan, muncul dialog konfirmasi:

```csharp
MessageBoxResult konfirmasi = MessageBox.Show(
    $"Yakin ingin menghapus data {mahasiswa.Nama} ({mahasiswa.NIM})?",
    "Konfirmasi Hapus", MessageBoxButton.YesNo, MessageBoxImage.Question);
```

Penghapusan dijalankan hanya jika pengguna menekan **Yes**:

```csharp
if (konfirmasi == MessageBoxResult.Yes)
{
    daftarMahasiswa.Remove(mahasiswa);
    PerbaruiJumlah();
}
```

Konfirmasi membantu mengurangi risiko penghapusan data secara tidak sengaja.

---

## 14. Fungsi `PerbaruiJumlah()`

```csharp
private void PerbaruiJumlah()
{
    txtJumlah.Text = $"Jumlah mahasiswa: {daftarMahasiswa.Count}";
}
```

Method ini membaca jumlah elemen dari koleksi dan menampilkannya di `TextBlock` `txtJumlah`. Pemanggilan dilakukan saat jendela dibuat, setelah mahasiswa ditambahkan, dan setelah mahasiswa berhasil dihapus.

---

## 15. Alur Kerja Program

```text
Program dijalankan
       |
       v
App.xaml membuka MainWindow
       |
       v
MainWindow() memuat GUI dan koleksi mahasiswa
       |
       v
Pengguna mengisi NIM, Nama, Prodi, Jenis Kelamin
       |
       v
    Pilih tindakan
       |
       +------------------+------------------+
       |                  |                  |
       v                  v                  v
     Simpan              Reset              Hapus
       |                  |                  |
       v                  v                  v
  Validasi input     Bersihkan form      Pilih mahasiswa
       |                                     |
  +----+----+                                v
  |         |                           Konfirmasi hapus
Tidak      Valid                               |
  |         |                            +----+----+
  v         v                            |         |
Pesan     Tambah ke                      No       Yes
error     koleksi                         |         |
            |                             v         v
            v                          Batal    Hapus data
       Daftar diperbarui                           |
            |                                      v
            +----------------------------> Perbarui jumlah
```

Pada penggunaan normal, daftar di sisi kanan akan langsung menampilkan data terbaru setelah operasi tambah atau hapus. Pengguna dapat mengulangi langkah tersebut selama jendela masih terbuka.

---

## 16. Konsep Pemrograman yang Digunakan

Program mengimplementasikan berbagai konsep C# dan WPF:

1. **Class dan Object:** class `Mahasiswa`, `MainWindow`, serta objek kontrol WPF.
2. **Property:** NIM, Nama, Prodi, dan JenisKelamin pada class `Mahasiswa`.
3. **Inheritance:** `MainWindow : Window` dan `App : Application`.
4. **Encapsulation:** field `daftarMahasiswa` bersifat `private` dan dikelola melalui method dalam `MainWindow`.
5. **Event-Driven Programming:** event `Click` memanggil `BtnSimpan_Click`, `BtnReset_Click`, serta `BtnHapus_Click`.
6. **Data Binding:** `ItemsSource` dan `{Binding ...}` menghubungkan objek mahasiswa dengan tampilannya di `ListBox`.
7. **Collection:** `ObservableCollection<Mahasiswa>` menampung kumpulan objek dan memberi notifikasi perubahan koleksi.
8. **LINQ:** `Any()` digunakan untuk mengecek apakah NIM sudah ada.
9. **Percabangan:** `if` digunakan untuk validasi dan konfirmasi.
10. **Method:** proses dipisahkan menjadi fungsi sesuai tanggung jawab.

Operasi yang tersedia termasuk **Create** (Simpan), **Read** (tampilan ListBox), dan **Delete** (Hapus). Operasi **Update/Edit** belum diimplementasikan.

---

## 17. Kelebihan Program

1. Menggunakan GUI WPF sehingga form lebih mudah digunakan daripada input console.
2. Memisahkan desain tampilan XAML dan logika C#.
3. Memiliki validasi input wajib.
4. Memiliki pengecekan NIM duplikat.
5. Memiliki tombol Reset untuk mengosongkan input.
6. Menampilkan data mahasiswa dengan `ListBox` dan `DataTemplate`.
7. Menggunakan `ObservableCollection` sehingga perubahan daftar dapat langsung tercermin pada UI.
8. Meminta konfirmasi sebelum data dihapus.
9. Menampilkan jumlah mahasiswa terdaftar.
10. Menggunakan model `Mahasiswa` sehingga struktur kode mudah dikembangkan.

---

## 18. Kekurangan Program

Program masih mempunyai beberapa keterbatasan:

1. **Belum menggunakan penyimpanan permanen:** data hilang setelah aplikasi ditutup.
2. **Belum tersedia fitur Edit/Update** untuk mengubah data mahasiswa.
3. **Belum tersedia fitur Search** berdasarkan NIM atau nama.
4. **Belum ada database** seperti SQL Server atau SQLite.
5. Data NIM belum divalidasi agar hanya berisi karakter angka.
6. Form hanya mencakup NIM, nama, program studi, dan jenis kelamin; belum ada tanggal lahir, alamat, ataupun nomor telepon.
7. Pilihan program studi masih ditulis langsung di XAML (belum diambil dari data dinamis).
8. Tidak terdapat autentikasi atau pembagian hak akses pengguna.
9. Aplikasi hanya dirancang untuk Windows karena menggunakan WPF.

---

## 19. Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dilakukan adalah:

1. Menambahkan `DatePicker` untuk tanggal lahir.
2. Menambahkan kolom alamat dan nomor telepon.
3. Mengimplementasikan fitur **Edit/Update** mahasiswa.
4. Menambahkan pencarian berdasarkan NIM dan nama.
5. Menambahkan pengurutan atau filter data.
6. Mengintegrasikan SQL Server atau SQLite agar data tersimpan permanen.
7. Memperluas validasi input, misalnya format NIM dan nomor telepon.
8. Memisahkan logika dari code-behind menggunakan pola **MVVM (Model–View–ViewModel)** jika aplikasi menjadi lebih kompleks.
9. Menambahkan fitur ekspor data ke CSV atau PDF.

---

## 20. Pengujian Program

Berikut skenario pengujian **yang dapat dilakukan** berdasarkan fungsi dalam kode. Tabel ini berisi **hasil yang diharapkan**, bukan klaim bahwa pengujian telah dilakukan secara langsung di Visual Studio.

| No. | Skenario | Hasil yang Diharapkan |
|---|---|---|
| 1 | Semua field kosong lalu klik Simpan | Muncul validasi NIM. |
| 2 | NIM kosong | Muncul pesan bahwa NIM wajib diisi. |
| 3 | Nama kosong | Muncul pesan bahwa nama wajib diisi. |
| 4 | Program studi belum dipilih | Muncul peringatan memilih prodi. |
| 5 | Jenis kelamin belum dipilih | Muncul peringatan memilih jenis kelamin. |
| 6 | Seluruh data valid | Data masuk ke ListBox, jumlah bertambah, dan form dibersihkan. |
| 7 | Menyimpan NIM yang sama dua kali | Muncul peringatan NIM sudah terdaftar. |
| 8 | Klik Reset | Input form dikosongkan, data pada ListBox tetap ada. |
| 9 | Klik Hapus tanpa memilih mahasiswa | Muncul pesan untuk memilih mahasiswa. |
| 10 | Klik Hapus lalu pilih No | Data tidak terhapus. |
| 11 | Klik Hapus lalu pilih Yes | Data terhapus dan jumlah mahasiswa berkurang. |

Contoh data untuk pengujian:

```text
NIM           : 5025231280
Nama          : Ananda Faris
Program Studi : Teknik Informatika
Jenis Kelamin : Laki-laki
```

---

## 21. Kesimpulan

**Student Registration App** adalah aplikasi desktop sederhana menggunakan **C#, .NET, dan Windows Presentation Foundation (WPF)** untuk mengelola pendaftaran mahasiswa. Program menyediakan formulir input NIM, nama, program studi, dan jenis kelamin; validasi data; fitur Simpan, Reset, serta Hapus; dan tampilan daftar berikut jumlah mahasiswa.

Struktur proyek memperlihatkan pembagian tugas antara **XAML sebagai antarmuka pengguna** dan **C# sebagai logika program**. Model `Mahasiswa` menyimpan informasi setiap mahasiswa, sedangkan `ObservableCollection<Mahasiswa>` menyediakan koleksi data yang terhubung dengan `ListBox`. Melalui proyek ini dapat dipelajari konsep class, object, property, inheritance, event handling, data binding, collection, validasi, dan operasi dasar pengelolaan data.

Aplikasi masih bersifat dasar karena belum memiliki fitur Edit/Update dan penyimpanan permanen. Pengembangan ke depan dapat dilakukan melalui pencarian, penambahan field registrasi, penerapan MVVM, serta integrasi database.
