using System;
using System.Collections.Generic;
using System.Text;

namespace DataMahasiswa
{
    // Class untuk merepresentasikan data mahasiswa
    class Mahasiswa
    {
        public string NIM { get; set; }
        public string Nama { get; set; }
        public string Prodi { get; set; }
        public double IPK { get; set; }

        // Constructor
        public Mahasiswa(string nim, string nama, string prodi, double ipk)
        {
            NIM = nim;
            Nama = nama;
            Prodi = prodi;
            IPK = ipk;
        }
    }

    class Program
    {
        // List untuk menyimpan data mahasiswa
        static List<Mahasiswa> daftarMahasiswa = new List<Mahasiswa>();

        static void Main(string[] args)
        {
            Console.OutputEncoding = Encoding.UTF8;

            int pilihan;

            do
            {
                TampilkanMenu();

                Console.ForegroundColor = ConsoleColor.White;
                Console.Write("Pilihan: ");

                string input = Console.ReadLine();

                if (!int.TryParse(input, out pilihan))
                {
                    pilihan = 0;
                }

                Console.WriteLine();

                switch (pilihan)
                {
                    case 1:
                        TambahMahasiswa();
                        break;

                    case 2:
                        TampilkanMahasiswa();
                        break;

                    case 3:
                        CariMahasiswa();
                        break;

                    case 4:
                        HapusMahasiswa();
                        break;

                    case 5:
                        Console.ForegroundColor = ConsoleColor.Green;
                        Console.WriteLine("Terima kasih telah menggunakan program.");
                        Console.ResetColor();
                        break;

                    default:
                        Console.ForegroundColor = ConsoleColor.Red;
                        Console.WriteLine("Pilihan tidak tersedia!");
                        Console.ResetColor();
                        break;
                }

                if (pilihan != 5)
                {
                    Console.WriteLine();
                    Console.ForegroundColor = ConsoleColor.DarkGray;
                    Console.WriteLine("Tekan ENTER untuk kembali ke menu...");
                    Console.ResetColor();

                    Console.ReadLine();
                }

            } while (pilihan != 5);
        }

        // ==========================================
        // METHOD MENAMPILKAN MENU
        // ==========================================
        static void TampilkanMenu()
        {
            Console.Clear();

            Console.ForegroundColor = ConsoleColor.Cyan;
            Console.WriteLine("╔════════════════════════════════════════════════════╗");
            Console.WriteLine("║           🎓 SISTEM DATA MAHASISWA                ║");
            Console.WriteLine("║        KELOLA DATA MAHASISWA DENGAN MUDAH         ║");
            Console.WriteLine("╠════════════════════════════════════════════════════╣");
            Console.ResetColor();

            Console.ForegroundColor = ConsoleColor.Green;
            Console.Write("║  1  ");
            Console.ResetColor();
            Console.WriteLine("👤  Tambah Mahasiswa");

            Console.ForegroundColor = ConsoleColor.Cyan;
            Console.Write("║  2  ");
            Console.ResetColor();
            Console.WriteLine("▣   Tampilkan Mahasiswa");

            Console.ForegroundColor = ConsoleColor.Yellow;
            Console.Write("║  3  ");
            Console.ResetColor();
            Console.WriteLine("🔍  Cari Mahasiswa");

            Console.ForegroundColor = ConsoleColor.Red;
            Console.Write("║  4  ");
            Console.ResetColor();
            Console.WriteLine("🗑   Hapus Mahasiswa");

            Console.ForegroundColor = ConsoleColor.Gray;
            Console.Write("║  5  ");
            Console.ResetColor();
            Console.WriteLine("🚪  Keluar");

            Console.ForegroundColor = ConsoleColor.Cyan;
            Console.WriteLine("╚════════════════════════════════════════════════════╝");
            Console.ResetColor();

            Console.WriteLine();
        }

        // ==========================================
        // METHOD TAMBAH MAHASISWA
        // ==========================================
        static void TambahMahasiswa()
        {
            Console.Clear();

            Judul("TAMBAH MAHASISWA");

            Console.Write("NIM           : ");
            string nim = Console.ReadLine();

            // Cek apakah NIM sudah digunakan
            foreach (Mahasiswa m in daftarMahasiswa)
            {
                if (m.NIM.Equals(nim, StringComparison.OrdinalIgnoreCase))
                {
                    Console.ForegroundColor = ConsoleColor.Red;
                    Console.WriteLine();
                    Console.WriteLine("NIM tersebut sudah terdaftar!");
                    Console.ResetColor();
                    return;
                }
            }

            Console.Write("Nama          : ");
            string nama = Console.ReadLine();

            Console.Write("Program Studi : ");
            string prodi = Console.ReadLine();

            double ipk;

            while (true)
            {
                Console.Write("IPK           : ");

                if (double.TryParse(Console.ReadLine(), out ipk))
                {
                    if (ipk >= 0 && ipk <= 4)
                    {
                        break;
                    }
                }

                Console.ForegroundColor = ConsoleColor.Red;
                Console.WriteLine("IPK harus berupa angka antara 0 - 4.");
                Console.ResetColor();
            }

            Mahasiswa mahasiswa = new Mahasiswa(
                nim,
                nama,
                prodi,
                ipk
            );

            daftarMahasiswa.Add(mahasiswa);

            Console.ForegroundColor = ConsoleColor.Green;
            Console.WriteLine();
            Console.WriteLine("✓ Data mahasiswa berhasil ditambahkan.");
            Console.ResetColor();
        }

        // ==========================================
        // METHOD MENAMPILKAN DATA
        // ==========================================
        static void TampilkanMahasiswa()
        {
            Console.Clear();

            Judul("DAFTAR MAHASISWA");

            if (daftarMahasiswa.Count == 0)
            {
                Console.ForegroundColor = ConsoleColor.Yellow;
                Console.WriteLine("Belum ada data mahasiswa.");
                Console.ResetColor();
                return;
            }

            Console.ForegroundColor = ConsoleColor.Cyan;

            Console.WriteLine(
                "{0,-15} {1,-25} {2,-25} {3,6}",
                "NIM",
                "Nama",
                "Program Studi",
                "IPK"
            );

            Console.WriteLine(
                new string('─', 75)
            );

            Console.ResetColor();

            foreach (Mahasiswa m in daftarMahasiswa)
            {
                Console.WriteLine(
                    "{0,-15} {1,-25} {2,-25} {3,6:F2}",
                    m.NIM,
                    m.Nama,
                    m.Prodi,
                    m.IPK
                );
            }

            Console.ForegroundColor = ConsoleColor.DarkGray;
            Console.WriteLine();
            Console.WriteLine($"Total mahasiswa: {daftarMahasiswa.Count}");
            Console.ResetColor();
        }

        // ==========================================
        // METHOD MENCARI MAHASISWA
        // ==========================================
        static void CariMahasiswa()
        {
            Console.Clear();

            Judul("CARI MAHASISWA");

            Console.Write("Masukkan NIM: ");
            string nimCari = Console.ReadLine();

            Mahasiswa mahasiswaDitemukan = null;

            foreach (Mahasiswa m in daftarMahasiswa)
            {
                if (m.NIM.Equals(
                    nimCari,
                    StringComparison.OrdinalIgnoreCase))
                {
                    mahasiswaDitemukan = m;
                    break;
                }
            }

            Console.WriteLine();

            if (mahasiswaDitemukan != null)
            {
                Console.ForegroundColor = ConsoleColor.Green;
                Console.WriteLine("✓ Data ditemukan!");
                Console.ResetColor();

                Console.WriteLine();
                Console.WriteLine($"NIM   : {mahasiswaDitemukan.NIM}");
                Console.WriteLine($"Nama  : {mahasiswaDitemukan.Nama}");
                Console.WriteLine($"Prodi : {mahasiswaDitemukan.Prodi}");
                Console.WriteLine($"IPK   : {mahasiswaDitemukan.IPK:F2}");
            }
            else
            {
                Console.ForegroundColor = ConsoleColor.Red;
                Console.WriteLine(
                    "Mahasiswa dengan NIM tersebut tidak ditemukan."
                );
                Console.ResetColor();
            }
        }

        // ==========================================
        // METHOD MENGHAPUS MAHASISWA
        // ==========================================
        static void HapusMahasiswa()
        {
            Console.Clear();

            Judul("HAPUS MAHASISWA");

            Console.Write("Masukkan NIM: ");
            string nimHapus = Console.ReadLine();

            Mahasiswa mahasiswaDitemukan = null;

            foreach (Mahasiswa m in daftarMahasiswa)
            {
                if (m.NIM.Equals(
                    nimHapus,
                    StringComparison.OrdinalIgnoreCase))
                {
                    mahasiswaDitemukan = m;
                    break;
                }
            }

            if (mahasiswaDitemukan != null)
            {
                Console.WriteLine();
                Console.WriteLine("Data mahasiswa:");
                Console.WriteLine($"NIM   : {mahasiswaDitemukan.NIM}");
                Console.WriteLine($"Nama  : {mahasiswaDitemukan.Nama}");
                Console.WriteLine($"Prodi : {mahasiswaDitemukan.Prodi}");
                Console.WriteLine($"IPK   : {mahasiswaDitemukan.IPK:F2}");

                Console.WriteLine();
                Console.Write("Yakin ingin menghapus data? (y/n): ");

                string konfirmasi = Console.ReadLine();

                if (konfirmasi.Equals(
                    "y",
                    StringComparison.OrdinalIgnoreCase))
                {
                    daftarMahasiswa.Remove(mahasiswaDitemukan);

                    Console.ForegroundColor = ConsoleColor.Green;
                    Console.WriteLine();
                    Console.WriteLine("✓ Data mahasiswa berhasil dihapus.");
                    Console.ResetColor();
                }
                else
                {
                    Console.ForegroundColor = ConsoleColor.Yellow;
                    Console.WriteLine();
                    Console.WriteLine("Penghapusan dibatalkan.");
                    Console.ResetColor();
                }
            }
            else
            {
                Console.ForegroundColor = ConsoleColor.Red;
                Console.WriteLine();
                Console.WriteLine("Data mahasiswa tidak ditemukan.");
                Console.ResetColor();
            }
        }

        // ==========================================
        // METHOD BANTUAN UNTUK JUDUL
        // ==========================================
        static void Judul(string teks)
        {
            Console.ForegroundColor = ConsoleColor.Cyan;

            Console.WriteLine(
                "════════════════════════════════════════════════════"
            );

            Console.WriteLine($" {teks}");

            Console.WriteLine(
                "════════════════════════════════════════════════════"
            );

            Console.ResetColor();

            Console.WriteLine();
        }
    }
}