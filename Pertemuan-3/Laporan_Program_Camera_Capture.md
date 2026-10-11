# LAPORAN PROGRAM CAMERA CAPTURE

## Identitas

**Nama:** Ananda Faris GR  
**NRP:** 5025231280  
**Pertemuan:** Pertemuan 3
**Tugas:** Program Camera Capture Menggunakan C# Windows Forms  

---

## 1. Latar Belakang

Perkembangan aplikasi desktop memungkinkan pengguna berinteraksi dengan perangkat keras komputer melalui antarmuka grafis (*Graphical User Interface*/GUI). Salah satu penerapannya adalah aplikasi kamera yang dapat menampilkan video secara langsung, mengambil foto dari webcam, dan menyimpan gambar ke komputer.

Pada tugas ini dibuat program **Camera Capture** menggunakan bahasa pemrograman **C#**, **Windows Forms**, serta library pihak ketiga **AForge.NET** untuk mengakses perangkat kamera melalui DirectShow. Pengembangan dilakukan dengan pendekatan *event-driven programming*: perintah dijalankan ketika pengguna menekan tombol atau ketika kamera mengirimkan frame baru.

Program menyediakan beberapa fungsi utama:

1. Mendeteksi kamera yang terhubung ke komputer.
2. Memilih kamera melalui *ComboBox*.
3. Menyalakan kamera dan menampilkan *live preview*.
4. Mengambil foto dari frame yang sedang ditampilkan.
5. Menyimpan foto dalam format JPEG (`.jpg`).
6. Menghentikan kamera dan membersihkan resource ketika aplikasi ditutup.

---

## 2. Alasan Menggunakan .NET

.NET menyediakan runtime, library, serta dukungan untuk membangun aplikasi desktop dengan C#. Program Camera Capture menggunakan API Windows Forms yang lazim digunakan pada proyek **.NET Framework** berbasis Windows. Versi target framework proyek tidak dapat dipastikan hanya dari kedua file sumber yang tersedia karena file konfigurasi proyek (`.csproj`) tidak dilampirkan.

### 2.1 Mendukung Bahasa C#

C# memiliki sintaks terstruktur dan mendukung konsep *Object-Oriented Programming* (OOP), termasuk class, object, encapsulation, dan inheritance. Aplikasi ini mendefinisikan class `Form1` yang mewarisi class `Form`.

```csharp
public class Form1 : Form
{
    // Komponen dan method aplikasi kamera
}
```

### 2.2 Memiliki Library yang Lengkap

Program menggunakan namespace bawaan .NET untuk menangani GUI, objek gambar, dialog penyimpanan, serta waktu dan tanggal:

```csharp
using System;
using System.Drawing;
using System.Drawing.Imaging;
using System.Windows.Forms;
```

`System.Windows.Forms` menyediakan `Form`, `Button`, `PictureBox`, `ComboBox`, `Label`, dan `SaveFileDialog`. `System.Drawing` menyediakan `Bitmap`, `Image`, `Color`, `Size`, dan `Point`.

### 2.3 Mendukung Object-Oriented Programming

Komponen kamera dan antarmuka dikelola sebagai objek dalam class `Form1`. Atribut seperti `videoSource` dan `capturedImage` dideklarasikan `private` sehingga pengelolaannya terpusat di dalam class.

### 2.4 Automatic Memory Management

Runtime .NET menyediakan **Garbage Collector (GC)** untuk pengelolaan memori objek terkelola. Namun, objek gambar dan kamera juga memakai resource yang perlu dilepaskan secara eksplisit. Oleh sebab itu, kode menggunakan `Dispose()` serta method `StopCamera()`.

### 2.5 Integrasi dengan Visual Studio

Visual Studio memudahkan pembuatan proyek Windows Forms, penulisan kode dengan IntelliSense, debugging, pengaturan referensi library, dan proses build. Library seperti AForge.NET perlu tersedia sebagai referensi proyek agar kode dapat dikompilasi.

### 2.6 Dapat Dikembangkan ke Berbagai Jenis Aplikasi

Arsitektur .NET memungkinkan proyek desktop ditingkatkan dengan fitur penyimpanan metadata, galeri foto, pengaturan resolusi, maupun proses pengolahan citra. Untuk mengakses kamera, implementasi khusus Windows pada proyek ini bergantung pada Windows Forms dan AForge DirectShow.

---

## 3. Penjelasan Implementasi

Kode sumber yang dianalisis terdiri dari **dua file**: `Program(1).cs` sebagai titik awal aplikasi dan `Form1.cs` sebagai pengelola GUI serta kamera. Nama file `Program(1).cs` merujuk pada nama file unggahan; di proyek Visual Studio, class `Program` biasanya disimpan sebagai `Program.cs`.

```text
CameraCapture
│
├── Program.cs
│   └── Program
│       └── Main()
│
└── Form1.cs
    └── Form1 : Form
        ├── Form1()                    [constructor]
        ├── InitializeUI()
        ├── LoadCameras()
        ├── BtnStart_Click()
        ├── VideoSource_NewFrame()
        ├── BtnCapture_Click()
        ├── BtnSave_Click()
        ├── BtnStop_Click()
        ├── StopCamera()
        └── Form1_FormClosing()
```

Aplikasi membuat komponen antarmuka **langsung melalui kode**, bukan melalui method `InitializeComponent()` yang dihasilkan Windows Forms Designer. Komponen terdiri atas daftar kamera, tombol Start/Stop, tampilan video, tampilan foto, tombol Capture/Save, dan label status.

---

## 4. Class `Program`

Class `Program` berfungsi sebagai wadah entry point aplikasi:

```csharp
internal static class Program
{
    [STAThread]
    static void Main()
    {
        Application.EnableVisualStyles();
        Application.SetCompatibleTextRenderingDefault(false);
        Application.Run(new Form1());
    }
}
```

`internal` membatasi akses class pada assembly yang sama. `static` menyatakan bahwa class ini tidak dibuat menjadi instance. Atribut `[STAThread]` mengatur model apartment thread utama agar mendukung komponen Windows yang memerlukannya.

---

## 5. Fungsi `Main()`

```csharp
static void Main()
{
    Application.EnableVisualStyles();
    Application.SetCompatibleTextRenderingDefault(false);
    Application.Run(new Form1());
}
```

`Main()` merupakan titik pertama yang dijalankan. `EnableVisualStyles()` mengaktifkan gaya visual Windows untuk kontrol aplikasi. `SetCompatibleTextRenderingDefault(false)` menetapkan pengaturan default rendering teks untuk kontrol yang relevan. `Application.Run(new Form1())` membuat jendela utama dan menjalankan *message loop* Windows Forms sampai aplikasi ditutup.

---

## 6. Class `Form1` dan Atributnya

```csharp
public class Form1 : Form
{
    private FilterInfoCollection cameraDevices;
    private VideoCaptureDevice videoSource;
    private Bitmap capturedImage;
}
```

Class `Form1` mewarisi class `Form` dari Windows Forms. Tiga atribut pentingnya adalah:

- `cameraDevices`: daftar perangkat kamera yang terdeteksi.
- `videoSource`: sumber video dari kamera terpilih.
- `capturedImage`: gambar hasil *capture* yang dapat disimpan.

Program juga memiliki atribut komponen GUI berikut:

| Atribut | Tipe | Fungsi |
|---|---|---|
| `cmbCamera` | `ComboBox` | Memilih kamera yang tersedia. |
| `pictureBoxLive` | `PictureBox` | Menampilkan video kamera secara langsung. |
| `pictureBoxCapture` | `PictureBox` | Menampilkan gambar hasil Capture. |
| `btnStart` | `Button` | Menyalakan kamera. |
| `btnStop` | `Button` | Menghentikan kamera. |
| `btnCapture` | `Button` | Mengambil foto. |
| `btnSave` | `Button` | Menyimpan foto. |
| `lblStatus` | `Label` | Menampilkan informasi status aplikasi. |

Penggunaan `private` membantu menerapkan **encapsulation**, yaitu membatasi akses langsung ke detail internal class.

---

## 7. Constructor `Form1()`

```csharp
public Form1()
{
    InitializeUI();
    LoadCameras();
}
```

Constructor dijalankan saat `new Form1()` dipanggil dalam `Main()`. Pertama, `InitializeUI()` membuat tampilan aplikasi. Setelah itu, `LoadCameras()` mencari perangkat kamera yang terhubung. Urutan ini penting karena dropdown `cmbCamera` harus dibuat sebelum daftar kamera dimasukkan ke dalamnya.

---

## 8. Fungsi `InitializeUI()`

```csharp
private void InitializeUI()
{
    Text = "Camera Capture";
    Size = new Size(900, 650);
    StartPosition = FormStartPosition.CenterScreen;
    FormBorderStyle = FormBorderStyle.FixedSingle;
    MaximizeBox = false;
    // Pembuatan serta penambahan kontrol ke Form
}
```

Fungsi ini mengatur judul, ukuran, posisi, dan perilaku jendela. Selanjutnya dibuat `Label`, `ComboBox`, empat `Button`, dua `PictureBox`, serta label status. Pengaturan `Location` menentukan posisi kontrol; `Size` menentukan ukurannya; `PictureBoxSizeMode.Zoom` menyesuaikan ukuran gambar tanpa perlu meregangkan proporsinya secara langsung.

Kontrol dimasukkan ke jendela melalui `Controls.Add(...)`. Setelah itu, tombol dihubungkan dengan *event handler*:

```csharp
btnStart.Click += BtnStart_Click;
btnStop.Click += BtnStop_Click;
btnCapture.Click += BtnCapture_Click;
btnSave.Click += BtnSave_Click;
FormClosing += Form1_FormClosing;
```

Simbol `+=` pada event mendaftarkan method agar dipanggil ketika event terjadi. Ini menjadi dasar **event-driven programming** dalam aplikasi.

---

## 9. Fungsi `LoadCameras()`

```csharp
cameraDevices = new FilterInfoCollection(
    FilterCategory.VideoInputDevice
);

cmbCamera.Items.Clear();
foreach (FilterInfo device in cameraDevices)
{
    cmbCamera.Items.Add(device.Name);
}
```

Fungsi ini menggunakan **AForge.Video.DirectShow** untuk mencari perangkat masukan video. Nama masing-masing perangkat ditambahkan ke ComboBox. Jika terdapat kamera, program memilih perangkat pertama (`SelectedIndex = 0`). Jika tidak ada, pengguna menerima pesan **"No camera detected!"**.

Pemanggilan diletakkan di dalam blok `try-catch` sehingga kesalahan saat mendeteksi perangkat ditampilkan melalui `MessageBox.Show(ex.Message)`.

---

## 10. Fungsi `BtnStart_Click()`

```csharp
private void BtnStart_Click(object sender, EventArgs e)
{
    if (cmbCamera.SelectedIndex < 0)
    {
        MessageBox.Show("Please select a camera.");
        return;
    }

    StopCamera();
    // Membuat sumber video dan memulai kamera
}
```

Fungsi ini dipanggil ketika pengguna menekan **Start Camera**. Program memeriksa pilihan kamera, menghentikan sumber sebelumnya, lalu membuat `VideoCaptureDevice` dari identitas `MonikerString` perangkat terpilih.

```csharp
videoSource = new VideoCaptureDevice(
    cameraDevices[cmbCamera.SelectedIndex].MonikerString
);
videoSource.NewFrame += VideoSource_NewFrame;
videoSource.Start();
```

Event `NewFrame` didaftarkan agar aplikasi menerima gambar baru dari kamera. Setelah pemanggilan `Start()`, teks status diubah menjadi **"Status: Camera running"** dan tombol Start dinonaktifkan. Apabila terjadi exception pada proses ini, program mencoba menghentikan kamera dan menampilkan pesan kesalahan.

---

## 11. Fungsi `VideoSource_NewFrame()`

```csharp
private void VideoSource_NewFrame(
    object sender, NewFrameEventArgs eventArgs)
{
    Bitmap frame = (Bitmap)eventArgs.Frame.Clone();
    // Memperbarui tampilan frame pada thread UI
}
```

Fungsi ini merupakan *callback* yang dipanggil ketika kamera mengirim frame baru. Setiap frame disalin dengan `Clone()` sehingga dapat dikelola terpisah dari frame asli milik AForge.

```csharp
pictureBoxLive.BeginInvoke(
    new Action(() =>
    {
        Image oldImage = pictureBoxLive.Image;
        pictureBoxLive.Image = frame;
        oldImage?.Dispose();
    })
);
```

`BeginInvoke()` menjadwalkan perubahan gambar pada thread antarmuka Windows Forms, karena callback kamera dapat berjalan pada thread yang berbeda. Setelah gambar baru dipasang, gambar lama dibersihkan menggunakan `Dispose()` supaya resource gambar tidak terus menumpuk.

Kode juga mengecek `IsHandleCreated` dan `IsDisposed`, serta menangani `InvalidOperationException` saat menjadwalkan pembaruan. Penanganan ini mengurangi risiko kesalahan ketika jendela sedang ditutup, walaupun tidak mencakup semua kemungkinan kondisi balapan (*race condition*).

---

## 12. Fungsi `BtnCapture_Click()`

```csharp
if (pictureBoxLive.Image == null)
{
    MessageBox.Show("Start the camera first!");
    return;
}

capturedImage?.Dispose();
capturedImage = new Bitmap(pictureBoxLive.Image);
```

Saat tombol **Capture** ditekan, program memastikan bahwa gambar live tersedia. Foto dibuat sebagai `Bitmap` baru dari frame yang saat itu ditampilkan, bukan dengan merekam video ke file. Jika sebelumnya sudah ada hasil Capture, resource gambar hasil lama dibebaskan.

```csharp
Image oldImage = pictureBoxCapture.Image;
pictureBoxCapture.Image = new Bitmap(capturedImage);
oldImage?.Dispose();
```

Gambar baru ditampilkan pada `pictureBoxCapture`, gambar lama pada panel preview dibersihkan, dan status diperbarui menjadi **"Status: Image captured"**.

---

## 13. Fungsi `BtnSave_Click()`

```csharp
if (capturedImage == null)
{
    MessageBox.Show("Capture an image first!");
    return;
}
```

Fungsi ini mencegah penyimpanan sebelum pengguna mengambil foto. Selanjutnya program membuka dialog pemilihan nama dan lokasi file:

```csharp
using (SaveFileDialog saveDialog = new SaveFileDialog())
{
    saveDialog.Filter = "JPEG Image|*.jpg";
    saveDialog.FileName =
        "Capture_" +
        DateTime.Now.ToString("yyyyMMdd_HHmmss") +
        ".jpg";
}
```

Pola nama file adalah `Capture_TAHUNBULANTANGGAL_JAMMENITDETIK.jpg`. Contoh: `Capture_20261011_143000.jpg`. Jika dialog dikonfirmasi dengan OK, program menyimpan gambar sebagai JPEG:

```csharp
capturedImage.Save(
    saveDialog.FileName,
    ImageFormat.Jpeg
);
```

Penggunaan blok `using` membantu memastikan resource dialog dibersihkan setelah selesai. Jika penyimpanan berhasil, pesan sukses ditampilkan; jika terjadi exception, aplikasi menampilkan pesan error.

---

## 14. Fungsi `BtnStop_Click()` dan `StopCamera()`

Event handler tombol Stop memanggil fungsi yang bertanggung jawab menghentikan perangkat:

```csharp
private void BtnStop_Click(object sender, EventArgs e)
{
    StopCamera();
    lblStatus.Text = "Status: Camera stopped";
}
```

Fungsi `StopCamera()` melakukan beberapa langkah:

```csharp
videoSource.NewFrame -= VideoSource_NewFrame;

if (videoSource.IsRunning)
{
    videoSource.SignalToStop();
    videoSource.WaitForStop();
}

videoSource = null;
btnStart.Enabled = true;
```

`-=` melepas event handler agar sumber video tidak lagi memanggilnya. `SignalToStop()` mengirim permintaan berhenti dan `WaitForStop()` menunggu proses kamera selesai. Setelah kamera dihentikan, referensi sumber diatur menjadi `null` dan tombol Start dapat digunakan kembali.

Dalam implementasi asli, proses tersebut hanya dijalankan ketika `videoSource != null`.

---

## 15. Fungsi `Form1_FormClosing()`

```csharp
private void Form1_FormClosing(
    object sender,
    FormClosingEventArgs e)
{
    StopCamera();
    pictureBoxLive.Image?.Dispose();
    pictureBoxCapture.Image?.Dispose();
    capturedImage?.Dispose();
}
```

Fungsi ini dipanggil ketika form akan ditutup. Program terlebih dahulu menghentikan kamera dan kemudian membebaskan resource gambar yang digunakan oleh preview langsung, preview hasil Capture, serta gambar hasil Capture yang disimpan di memori. Pembersihan resource penting untuk menghindari perangkat tetap dipakai oleh aplikasi setelah jendela ditutup.

---

## 16. Alur Kerja Program

```text
Aplikasi dijalankan
        |
        v
Program.Main()
        |
        v
new Form1()
        |
        +--> InitializeUI() --> Membuat jendela dan tombol
        |
        +--> LoadCameras()  --> Mencari perangkat kamera
        |
        v
Pengguna memilih kamera
        |
        v
Klik "Start Camera"
        |
        v
VideoCaptureDevice.Start()
        |
        v
NewFrame --> pictureBoxLive (video langsung)
        |
        +----> Klik "Capture"
        |           |
        |           v
        |      Salin frame ke capturedImage
        |           |
        |           v
        |      Tampilkan di pictureBoxCapture
        |           |
        |           v
        |      Klik "Save Image" (opsional)
        |           |
        |           v
        |      Pilih lokasi --> Simpan JPEG
        |
        +----> Klik "Stop Camera"
                    |
                    v
               StopCamera()
                    |
                    v
               Kamera berhenti

Saat jendela ditutup:
Form1_FormClosing() --> StopCamera() --> Dispose() gambar
```

Proses Capture dan Save bersifat opsional. Pengguna juga dapat menghentikan kamera tanpa harus mengambil atau menyimpan gambar.

---

## 17. Konsep Pemrograman yang Digunakan

Program Camera Capture memanfaatkan beberapa konsep C# dan .NET:

1. **Class dan Object:** `Program`, `Form1`, `Button`, `Bitmap`, dan `VideoCaptureDevice`.
2. **Inheritance:** `Form1 : Form` mewarisi kemampuan jendela Windows Forms.
3. **Encapsulation:** field `private` menyembunyikan detail pengelolaan kamera serta gambar.
4. **Constructor:** `Form1()` menyiapkan GUI dan mendeteksi kamera ketika form dibuat.
5. **Event-driven programming:** event `Click`, `NewFrame`, dan `FormClosing` menentukan respons aplikasi.
6. **Callback dan delegate:** `new Action(() => ...)` digunakan untuk pekerjaan pembaruan tampilan pada thread UI.
7. **Multithreading:** `BeginInvoke()` membantu mengakses kontrol UI dari callback kamera secara aman sesuai model threading Windows Forms.
8. **Percabangan:** `if`, `else`, dan `try-catch` menangani kondisi dan kesalahan.
9. **Perulangan:** `foreach` menelusuri daftar perangkat kamera.
10. **Pengelolaan resource:** `Dispose()`, `using`, `SignalToStop()`, serta `WaitForStop()`.
11. **File I/O:** `SaveFileDialog` dan `Bitmap.Save()` menyimpan gambar JPEG.

Program menggunakan OOP terutama melalui class, objek, inheritance, dan encapsulation. Implementasi khusus untuk overriding/polymorphism oleh class buatan sendiri tidak ditunjukkan secara eksplisit pada kode yang dilampirkan.

---

## 18. Kelebihan Program

1. Memiliki GUI berbasis Windows Forms yang mudah dioperasikan.
2. Dapat mendeteksi beberapa perangkat kamera dan menampilkannya dalam ComboBox.
3. Menyediakan *live preview* sebelum melakukan Capture.
4. Memisahkan hasil foto dari tampilan kamera langsung.
5. Menyediakan dialog lokasi penyimpanan dan menghasilkan file JPEG.
6. Menggunakan nama file default berdasarkan tanggal dan waktu.
7. Memiliki label status untuk memberikan informasi kepada pengguna.
8. Menggunakan pemeriksaan kondisi sebelum Start, Capture, dan Save.
9. Menggunakan `BeginInvoke()` untuk memperbarui kontrol dari callback frame kamera.
10. Memiliki langkah penghentian kamera dan pembersihan objek gambar.

---

## 19. Kekurangan Program

Program masih memiliki beberapa keterbatasan yang terlihat dari kode sumber:

- Hanya menyimpan hasil Capture dalam format JPEG.
- Belum menyediakan pilihan resolusi video atau kualitas kompresi JPEG.
- Belum menyediakan fitur rekam video.
- Belum menyediakan pengaturan efek gambar, rotasi, maupun crop.
- Belum menyediakan galeri atau riwayat hasil Capture.
- Belum menyimpan konfigurasi kamera secara permanen.
- Belum memiliki penanganan lengkap untuk kamera yang dicabut atau gagal saat proses streaming.
- Proses `WaitForStop()` yang dipanggil dari thread GUI berpotensi membuat antarmuka tidak responsif selama penghentian kamera.
- Penanganan frame saat form ditutup masih berpotensi mengalami kondisi balapan tertentu yang memerlukan pengujian lebih lanjut.
- Bergantung pada AForge.NET/DirectShow sehingga kompatibilitas library, perangkat, dan target .NET perlu diperhatikan.

Keterbatasan di atas merupakan **analisis kode**, bukan hasil pengujian langsung pada perangkat kamera tertentu.

---

## 20. Pengembangan Selanjutnya

Pengembangan program dapat dilakukan melalui:

1. Menambahkan pengaturan resolusi serta frame rate kamera.
2. Menyediakan penyimpanan dalam format PNG dan pengaturan kualitas JPEG.
3. Menambahkan fitur perekaman video.
4. Membuat fitur galeri untuk menampilkan hasil Capture.
5. Menambahkan timestamp atau watermark pada foto.
6. Menyediakan tombol untuk memilih folder penyimpanan default.
7. Meningkatkan penanganan kamera yang terputus dan error saat streaming.
8. Memperbaiki sinkronisasi callback frame dan proses penutupan form.
9. Memisahkan logika kamera dari class GUI agar lebih mudah dipelihara dan diuji.
10. Mengevaluasi library kamera yang lebih modern apabila proyek dikembangkan lebih lanjut.

---

## 21. Kesimpulan

Program **Camera Capture** merupakan aplikasi desktop berbasis C# dan Windows Forms yang menggunakan AForge.NET untuk mengakses perangkat kamera. Aplikasi dapat mendeteksi webcam, memulai dan menghentikan streaming, menampilkan video secara langsung, mengambil foto dari frame yang terlihat, serta menyimpan gambar hasil Capture sebagai file JPEG.

Struktur program dibagi menjadi `Program.cs` sebagai titik awal aplikasi dan `Form1.cs` sebagai pusat pengelolaan antarmuka, kamera, dan gambar. Melalui proyek ini, mahasiswa dapat mempelajari penggunaan **class, object, inheritance, constructor, method, event handling, callback, multithreading dasar, pengolahan Bitmap, dialog penyimpanan, serta pengelolaan resource** dalam pengembangan perangkat lunak desktop.

Program telah mencakup alur dasar pengambilan foto menggunakan webcam, tetapi masih dapat dikembangkan pada aspek konfigurasi kamera, format output, ketahanan ketika terjadi kesalahan, dan pengelolaan event secara lebih aman.

---

