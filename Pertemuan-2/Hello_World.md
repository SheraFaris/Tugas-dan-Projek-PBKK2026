# LAPORAN PROGRAM HELLO WORLD C#

## Identitas

**Nama:** Ananda Faris GR  
**NRP:** 5025231280  
**Pertemuan:** 2  
**Tugas:** Program Hello World C#  

---

## 1. Latar Belakang

Program **Hello World** merupakan program sederhana yang umum digunakan sebagai langkah awal dalam mempelajari bahasa pemrograman baru.

Pada tugas ini, program Hello World dibuat menggunakan bahasa pemrograman **C#** dengan platform **.NET** melalui Visual Studio. Program ini digunakan untuk memahami struktur paling dasar dari program C#, terutama cara menampilkan teks ke console.

Kode yang digunakan adalah:

```csharp
Console.WriteLine("Hello, World!");
```

Walaupun hanya terdiri dari satu baris, program ini memperkenalkan beberapa konsep dasar dalam C#, yaitu:

- Penggunaan class bawaan `Console`.
- Pemanggilan method `WriteLine()`.
- Penggunaan string.
- Penulisan statement.
- Proses compile dan menjalankan program C#.
- Struktur project C# pada Visual Studio.

Program ini menjadi dasar sebelum mempelajari konsep yang lebih kompleks seperti variable, tipe data, percabangan, perulangan, method, class, dan object.

---

## 2. Mengapa Menggunakan C#

C# merupakan bahasa pemrograman yang dikembangkan oleh Microsoft dan menjadi salah satu bahasa utama dalam ekosistem .NET.

C# dipilih karena memiliki beberapa keunggulan.

### 2.1 Sintaks Terstruktur dan Mudah Dibaca

C# memiliki sintaks yang cukup jelas dan terstruktur.

Contohnya:

```csharp
Console.WriteLine("Hello, World!");
```

Dari kode tersebut dapat terlihat bahwa program meminta `Console` untuk menjalankan fungsi `WriteLine()` dan menampilkan teks `"Hello, World!"`.

Sintaks yang terstruktur membantu programmer memahami alur program dengan lebih mudah.

### 2.2 Mendukung Object-Oriented Programming

C# merupakan bahasa yang mendukung konsep **Object-Oriented Programming (OOP)**.

Konsep ini memungkinkan program dikembangkan menggunakan:

- Class.
- Object.
- Property.
- Method.
- Inheritance.
- Encapsulation.
- Polymorphism.

Walaupun program Hello World belum menggunakan konsep OOP secara langsung, pemahaman sintaks dasar C# menjadi fondasi sebelum mempelajari konsep tersebut.

### 2.3 Terintegrasi dengan .NET

C# memiliki integrasi yang sangat baik dengan .NET.

.NET menyediakan library dan runtime yang dapat digunakan untuk membuat berbagai jenis aplikasi, seperti:

- Console Application.
- Desktop Application.
- Web Application.
- Web API.
- Cloud Application.

Pada program ini, class `Console` disediakan oleh library .NET dan digunakan untuk berinteraksi dengan terminal.

### 2.4 Dukungan Visual Studio

C# dapat dikembangkan dengan mudah menggunakan Visual Studio.

Visual Studio menyediakan fitur seperti:

- IntelliSense.
- Syntax highlighting.
- Debugging.
- Error detection.
- Build dan run program.
- Project management.

Fitur tersebut membantu programmer menulis dan menguji kode dengan lebih cepat.

---

## 3. Implementasi Program

Program yang dibuat sangat sederhana dan hanya berisi satu statement utama:

```csharp
Console.WriteLine("Hello, World!");
```

Ketika program dijalankan, hasilnya adalah:

```text
Hello, World!
```

Program tersebut menggunakan fitur **top-level statements** pada C# modern.

Dengan fitur ini, programmer tidak harus menuliskan struktur lengkap seperti:

```csharp
using System;

class Program
{
    static void Main(string[] args)
    {
        Console.WriteLine("Hello, World!");
    }
}
```

Pada project C# modern, kode berikut:

```csharp
Console.WriteLine("Hello, World!");
```

secara otomatis dijalankan sebagai bagian utama program.

---

## 4. Penjelasan `Console`

Bagian pertama dari program adalah:

```csharp
Console
```

`Console` merupakan class bawaan dari .NET yang digunakan untuk melakukan input dan output pada aplikasi console.

Beberapa fungsi yang umum digunakan dari `Console` adalah:

```csharp
Console.WriteLine();
Console.Write();
Console.ReadLine();
Console.Clear();
```

Kegunaannya adalah:

| Perintah | Fungsi |
|---|---|
| `Console.WriteLine()` | Menampilkan teks lalu berpindah ke baris baru |
| `Console.Write()` | Menampilkan teks tanpa berpindah ke baris baru |
| `Console.ReadLine()` | Membaca input dari pengguna |
| `Console.Clear()` | Membersihkan tampilan console |

Pada program Hello World, fungsi yang digunakan adalah:

```csharp
Console.WriteLine();
```

---

## 5. Penjelasan `WriteLine()`

`WriteLine()` merupakan method dari class `Console`.

Kode:

```csharp
Console.WriteLine("Hello, World!");
```

memiliki arti:

1. Mengakses class `Console`.
2. Memanggil method `WriteLine()`.
3. Mengirimkan teks `"Hello, World!"` sebagai parameter.
4. Menampilkan teks tersebut ke console.
5. Memindahkan posisi cursor ke baris berikutnya.

Sebagai contoh:

```csharp
Console.WriteLine("Baris pertama");
Console.WriteLine("Baris kedua");
```

akan menghasilkan:

```text
Baris pertama
Baris kedua
```

Hal ini berbeda dengan `Console.Write()`.

Contoh:

```csharp
Console.Write("Hello ");
Console.Write("World");
```

akan menghasilkan:

```text
Hello World
```

karena `Write()` tidak membuat baris baru setelah teks ditampilkan.

---

## 6. Penjelasan String `"Hello, World!"`

Bagian:

```csharp
"Hello, World!"
```

merupakan sebuah **string**.

String adalah tipe data yang digunakan untuk menyimpan kumpulan karakter atau teks.

Dalam C#, nilai string ditulis menggunakan tanda petik ganda.

Contoh:

```csharp
"Hello"
"Ananda Faris"
"Informatika"
"5025231280"
```

Pada program:

```csharp
Console.WriteLine("Hello, World!");
```

string `"Hello, World!"` dikirimkan sebagai argument ke method `WriteLine()`.

---

## 7. Tanda Titik Koma `;`

Pada akhir statement terdapat tanda:

```csharp
;
```

Contoh:

```csharp
Console.WriteLine("Hello, World!");
```

Tanda titik koma digunakan untuk menandai akhir sebuah statement dalam C#.

Contoh statement lainnya:

```csharp
int umur = 20;
string nama = "Ananda";
Console.WriteLine(nama);
```

Masing-masing perintah diakhiri dengan titik koma.

---

## 8. Struktur Pemanggilan Method

Kode:

```csharp
Console.WriteLine("Hello, World!");
```

dapat dibaca sebagai:

```text
Console
   |
   v
WriteLine()
   |
   v
"Hello, World!"
```

atau:

```text
Class
  |
  +-- Method
        |
        +-- Argument
```

Dalam program ini:

```text
Class    : Console
Method   : WriteLine
Argument : "Hello, World!"
```

Hal ini memperkenalkan pola dasar pemanggilan method pada C#.

---

## 9. Top-Level Statements

Pada project C# modern, Visual Studio dapat membuat file `Program.cs` dengan isi:

```csharp
Console.WriteLine("Hello, World!");
```

Ini disebut **top-level statements**.

Dengan top-level statements, programmer dapat menulis program sederhana tanpa harus menuliskan:

```csharp
class Program
{
    static void Main(string[] args)
    {
    }
}
```

Kode sederhana tersebut pada dasarnya memiliki fungsi yang sama dengan:

```csharp
using System;

class Program
{
    static void Main(string[] args)
    {
        Console.WriteLine("Hello, World!");
    }
}
```

Top-level statements membuat program awal lebih ringkas dan memudahkan pembelajaran dasar C#.

---

## 10. Fungsi `Main()` pada C#

Pada bentuk C# tradisional, program biasanya memiliki:

```csharp
static void Main(string[] args)
```

`Main()` merupakan **entry point** atau titik awal program.

Contoh:

```csharp
class Program
{
    static void Main(string[] args)
    {
        Console.WriteLine("Hello, World!");
    }
}
```

Ketika program dijalankan, .NET akan memulai eksekusi dari `Main()`.

Pada project yang menggunakan top-level statements, compiler C# akan menangani struktur entry point tersebut secara otomatis.

---

## 11. Alur Eksekusi Program

Alur kerja program Hello World adalah:

```text
Program dijalankan
       |
       v
.NET menjalankan program C#
       |
       v
Console.WriteLine() dipanggil
       |
       v
String "Hello, World!" dikirim ke method
       |
       v
Teks ditampilkan di console
       |
       v
Program selesai
```

Karena tidak ada perulangan atau input tambahan, program akan langsung selesai setelah teks ditampilkan.

---

## 12. Compile dan Run

Kode C# yang ditulis pada file:

```text
Program.cs
```

tidak langsung dijalankan oleh komputer.

Secara sederhana prosesnya adalah:

```text
Source Code C#
      |
      v
Compiler
      |
      v
Intermediate Language
      |
      v
.NET Runtime
      |
      v
Program dijalankan
```

Visual Studio menangani proses build dan run tersebut secara otomatis.

Program dapat dijalankan menggunakan tombol **Start** di Visual Studio atau shortcut:

```text
Ctrl + F5
```

Setelah dijalankan, console akan menampilkan:

```text
Hello, World!
```

---

## 13. Contoh Pengembangan Program

Program Hello World dapat dikembangkan untuk menampilkan lebih banyak informasi.

Contoh:

```csharp
Console.WriteLine("Hello, World!");
Console.WriteLine("Nama: Ananda Faris GR");
Console.WriteLine("NRP: 5025231280");
Console.WriteLine("Program Studi: Informatika");
```

Output:

```text
Hello, World!
Nama: Ananda Faris GR
NRP: 5025231280
Program Studi: Informatika
```

Dari contoh tersebut dapat dipahami bahwa `Console.WriteLine()` dapat digunakan berkali-kali untuk menampilkan informasi yang berbeda.

---

## 14. Contoh Menggunakan Variable

Setelah memahami Hello World, program dapat dikembangkan dengan menggunakan variable.

Contoh:

```csharp
string nama = "Ananda Faris GR";
string nrp = "5025231280";

Console.WriteLine("Hello, World!");
Console.WriteLine("Nama: " + nama);
Console.WriteLine("NRP: " + nrp);
```

Variable digunakan untuk menyimpan data sehingga nilai tersebut dapat digunakan kembali pada program.

Contoh tersebut menghasilkan:

```text
Hello, World!
Nama: Ananda Faris GR
NRP: 5025231280
```

---

## 15. Contoh Input dari Pengguna

Program juga dapat dikembangkan agar menerima input.

```csharp
Console.Write("Masukkan nama: ");
string nama = Console.ReadLine();

Console.WriteLine("Hello, " + nama + "!");
```

Contoh eksekusi:

```text
Masukkan nama: Ananda
Hello, Ananda!
```

Pada contoh tersebut:

```csharp
Console.Write()
```

digunakan untuk menampilkan pertanyaan, sedangkan:

```csharp
Console.ReadLine()
```

digunakan untuk membaca input pengguna.

---

## 16. Konsep Dasar C# yang Dipelajari

Melalui program Hello World, beberapa konsep dasar C# yang dapat dipelajari adalah:

### Statement

```csharp
Console.WriteLine("Hello, World!");
```

merupakan sebuah statement atau instruksi yang akan dijalankan oleh program.

### Class

```csharp
Console
```

merupakan class yang disediakan oleh .NET.

### Method

```csharp
WriteLine()
```

merupakan method yang dimiliki oleh class `Console`.

### Argument

```csharp
"Hello, World!"
```

merupakan argument yang dikirim ke method `WriteLine()`.

### String

```csharp
"Hello, World!"
```

merupakan data bertipe string.

### Semicolon

```csharp
;
```

digunakan sebagai penanda akhir statement.

### Top-Level Statement

C# modern memungkinkan kode ditulis langsung di dalam `Program.cs` tanpa harus menuliskan class `Program` dan method `Main()` secara manual.

---

## 17. Kelebihan Program

Program Hello World memiliki beberapa kelebihan sebagai program pembelajaran awal:

1. Kode sangat sederhana.
2. Mudah dijalankan dan dipahami.
3. Memperkenalkan sintaks dasar C#.
4. Memperkenalkan penggunaan class dan method.
5. Memperkenalkan output pada console.
6. Memperkenalkan penggunaan string.
7. Memperkenalkan proses compile dan run.
8. Menjadi dasar untuk program C# yang lebih kompleks.

---

## 18. Kekurangan Program

Karena hanya merupakan program pengenalan, Hello World memiliki fungsi yang sangat terbatas.

Program belum memiliki:

- Input dari pengguna.
- Variable.
- Operasi matematika.
- Percabangan.
- Perulangan.
- Method buatan sendiri.
- Class buatan sendiri.
- Penyimpanan data.

Namun, keterbatasan tersebut memang sesuai dengan tujuan program Hello World, yaitu sebagai pengenalan awal terhadap bahasa C#.

---

## 19. Kesimpulan

Program Hello World merupakan contoh paling sederhana untuk memahami penggunaan dasar bahasa pemrograman C#.

Kode:

```csharp
Console.WriteLine("Hello, World!");
```

digunakan untuk menampilkan teks `"Hello, World!"` pada console.

Walaupun sederhana, kode tersebut memperkenalkan beberapa konsep dasar, yaitu:

- `Console` sebagai class.
- `WriteLine()` sebagai method.
- `"Hello, World!"` sebagai string dan argument.
- `;` sebagai akhir statement.
- Top-level statements pada C# modern.

Program ini juga membantu memahami bagaimana sebuah program C# dibuat, di-build, dan dijalankan menggunakan .NET dan Visual Studio.

Setelah memahami program Hello World, pembelajaran C# dapat dilanjutkan ke materi seperti variable, tipe data, input-output, operator, percabangan, perulangan, method, class, object, dan Object-Oriented Programming.
