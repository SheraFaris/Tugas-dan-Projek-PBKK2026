using System.Collections.ObjectModel;
using System.Linq;
using System.Windows;
using System.Windows.Controls;

namespace StudentRegistrationApp;

public partial class MainWindow : Window
{
    // ObservableCollection memperbarui ListBox ketika data ditambah/dihapus.
    private readonly ObservableCollection<Mahasiswa> daftarMahasiswa = new();

    public MainWindow()
    {
        InitializeComponent();
        lstMahasiswa.ItemsSource = daftarMahasiswa;
        PerbaruiJumlah();
    }

    private void BtnSimpan_Click(object sender, RoutedEventArgs e)
    {
        string nim = txtNim.Text.Trim();
        string nama = txtNama.Text.Trim();

        if (string.IsNullOrWhiteSpace(nim))
        {
            MessageBox.Show("NIM harus diisi!", "Validasi", MessageBoxButton.OK, MessageBoxImage.Warning);
            txtNim.Focus();
            return;
        }

        if (string.IsNullOrWhiteSpace(nama))
        {
            MessageBox.Show("Nama harus diisi!", "Validasi", MessageBoxButton.OK, MessageBoxImage.Warning);
            txtNama.Focus();
            return;
        }

        if (cmbProdi.SelectedItem is not ComboBoxItem item)
        {
            MessageBox.Show("Pilih program studi!", "Validasi", MessageBoxButton.OK, MessageBoxImage.Warning);
            cmbProdi.Focus();
            return;
        }

        if (rbLaki.IsChecked != true && rbPerempuan.IsChecked != true)
        {
            MessageBox.Show("Pilih jenis kelamin!", "Validasi", MessageBoxButton.OK, MessageBoxImage.Warning);
            return;
        }

        if (daftarMahasiswa.Any(m => string.Equals(m.NIM, nim, System.StringComparison.OrdinalIgnoreCase)))
        {
            MessageBox.Show("NIM tersebut sudah terdaftar!", "Validasi", MessageBoxButton.OK, MessageBoxImage.Warning);
            txtNim.Focus();
            return;
        }

        Mahasiswa mahasiswa = new()
        {
            NIM = nim,
            Nama = nama,
            Prodi = item.Content?.ToString() ?? string.Empty,
            JenisKelamin = rbLaki.IsChecked == true ? "Laki-laki" : "Perempuan"
        };

        daftarMahasiswa.Add(mahasiswa);
        PerbaruiJumlah();
        BersihkanForm();
        MessageBox.Show("Data mahasiswa berhasil disimpan!", "Informasi",
                        MessageBoxButton.OK, MessageBoxImage.Information);
    }

    private void BtnReset_Click(object sender, RoutedEventArgs e)
    {
        BersihkanForm();
    }

    private void BersihkanForm()
    {
        txtNim.Clear();
        txtNama.Clear();
        cmbProdi.SelectedIndex = -1;
        rbLaki.IsChecked = false;
        rbPerempuan.IsChecked = false;
        txtNim.Focus();
    }

    private void BtnHapus_Click(object sender, RoutedEventArgs e)
    {
        if (lstMahasiswa.SelectedItem is not Mahasiswa mahasiswa)
        {
            MessageBox.Show("Pilih data mahasiswa yang ingin dihapus!", "Informasi",
                            MessageBoxButton.OK, MessageBoxImage.Information);
            return;
        }

        MessageBoxResult konfirmasi = MessageBox.Show(
            $"Yakin ingin menghapus data {mahasiswa.Nama} ({mahasiswa.NIM})?",
            "Konfirmasi Hapus", MessageBoxButton.YesNo, MessageBoxImage.Question);

        if (konfirmasi == MessageBoxResult.Yes)
        {
            daftarMahasiswa.Remove(mahasiswa);
            PerbaruiJumlah();
        }
    }

    private void PerbaruiJumlah()
    {
        txtJumlah.Text = $"Jumlah mahasiswa: {daftarMahasiswa.Count}";
    }
}
