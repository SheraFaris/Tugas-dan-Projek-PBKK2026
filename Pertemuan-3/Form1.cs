using System;
using System.Drawing;
using System.Drawing.Imaging;
using System.Windows.Forms;
using AForge.Video;
using AForge.Video.DirectShow;

namespace CameraCapture
{
    public class Form1 : Form
    {
        // Perangkat kamera
        private FilterInfoCollection cameraDevices;
        private VideoCaptureDevice videoSource;

        // Hasil pengambilan gambar
        private Bitmap capturedImage;

        // Komponen antarmuka
        private ComboBox cmbCamera;
        private PictureBox pictureBoxLive;
        private PictureBox pictureBoxCapture;

        private Button btnStart;
        private Button btnCapture;
        private Button btnSave;
        private Button btnStop;

        private Label lblStatus;

        public Form1()
        {
            InitializeUI();
            LoadCameras();
        }

        // Membuat tampilan program
        private void InitializeUI()
        {
            Text = "Camera Capture";
            Size = new Size(900, 650);
            StartPosition = FormStartPosition.CenterScreen;
            FormBorderStyle = FormBorderStyle.FixedSingle;
            MaximizeBox = false;

            Label lblCamera = new Label
            {
                Text = "Select Camera:",
                Location = new Point(20, 20),
                AutoSize = true
            };

            cmbCamera = new ComboBox
            {
                Location = new Point(130, 17),
                Width = 300,
                DropDownStyle = ComboBoxStyle.DropDownList
            };

            btnStart = new Button
            {
                Text = "Start Camera",
                Location = new Point(450, 15),
                Size = new Size(120, 30)
            };

            btnStop = new Button
            {
                Text = "Stop Camera",
                Location = new Point(580, 15),
                Size = new Size(120, 30)
            };

            pictureBoxLive = new PictureBox
            {
                Location = new Point(20, 70),
                Size = new Size(520, 390),
                BorderStyle = BorderStyle.FixedSingle,
                SizeMode = PictureBoxSizeMode.Zoom,
                BackColor = Color.Black
            };

            pictureBoxCapture = new PictureBox
            {
                Location = new Point(560, 70),
                Size = new Size(300, 230),
                BorderStyle = BorderStyle.FixedSingle,
                SizeMode = PictureBoxSizeMode.Zoom,
                BackColor = Color.LightGray
            };

            btnCapture = new Button
            {
                Text = "Capture",
                Location = new Point(560, 320),
                Size = new Size(140, 40)
            };

            btnSave = new Button
            {
                Text = "Save Image",
                Location = new Point(720, 320),
                Size = new Size(140, 40)
            };

            lblStatus = new Label
            {
                Text = "Status: Camera not started",
                Location = new Point(20, 490),
                AutoSize = true
            };

            Controls.Add(lblCamera);
            Controls.Add(cmbCamera);
            Controls.Add(btnStart);
            Controls.Add(btnStop);
            Controls.Add(pictureBoxLive);
            Controls.Add(pictureBoxCapture);
            Controls.Add(btnCapture);
            Controls.Add(btnSave);
            Controls.Add(lblStatus);

            // Event tombol
            btnStart.Click += BtnStart_Click;
            btnStop.Click += BtnStop_Click;
            btnCapture.Click += BtnCapture_Click;
            btnSave.Click += BtnSave_Click;

            FormClosing += Form1_FormClosing;
        }

        // Mencari kamera yang terhubung
        private void LoadCameras()
        {
            try
            {
                cameraDevices = new FilterInfoCollection(
                    FilterCategory.VideoInputDevice
                );

                cmbCamera.Items.Clear();

                foreach (FilterInfo device in cameraDevices)
                {
                    cmbCamera.Items.Add(device.Name);
                }

                if (cmbCamera.Items.Count > 0)
                {
                    cmbCamera.SelectedIndex = 0;
                }
                else
                {
                    MessageBox.Show("No camera detected!");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        // Menyalakan kamera
        private void BtnStart_Click(object sender, EventArgs e)
        {
            if (cmbCamera.SelectedIndex < 0)
            {
                MessageBox.Show("Please select a camera.");
                return;
            }

            StopCamera();

            try
            {
                videoSource = new VideoCaptureDevice(
                    cameraDevices[cmbCamera.SelectedIndex].MonikerString
                );

                videoSource.NewFrame += VideoSource_NewFrame;
                videoSource.Start();

                lblStatus.Text = "Status: Camera running";
                btnStart.Enabled = false;
            }
            catch (Exception ex)
            {
                StopCamera();
                MessageBox.Show(ex.Message);
            }
        }

        // Menampilkan frame kamera
        private void VideoSource_NewFrame(
            object sender,
            NewFrameEventArgs eventArgs)
        {
            Bitmap frame = (Bitmap)eventArgs.Frame.Clone();

            try
            {
                if (pictureBoxLive.IsHandleCreated &&
                    !pictureBoxLive.IsDisposed)
                {
                    pictureBoxLive.BeginInvoke(
                        new Action(() =>
                        {
                            Image oldImage = pictureBoxLive.Image;
                            pictureBoxLive.Image = frame;
                            oldImage?.Dispose();
                        })
                    );
                }
                else
                {
                    frame.Dispose();
                }
            }
            catch (InvalidOperationException)
            {
                frame.Dispose();
            }
        }

        // Mengambil foto
        private void BtnCapture_Click(object sender, EventArgs e)
        {
            if (pictureBoxLive.Image == null)
            {
                MessageBox.Show("Start the camera first!");
                return;
            }

            capturedImage?.Dispose();

            capturedImage =
                new Bitmap(pictureBoxLive.Image);

            Image oldImage = pictureBoxCapture.Image;

            pictureBoxCapture.Image =
                new Bitmap(capturedImage);

            oldImage?.Dispose();

            lblStatus.Text = "Status: Image captured";
        }

        // Menyimpan foto
        private void BtnSave_Click(object sender, EventArgs e)
        {
            if (capturedImage == null)
            {
                MessageBox.Show("Capture an image first!");
                return;
            }

            using (SaveFileDialog saveDialog = new SaveFileDialog())
            {
                saveDialog.Filter = "JPEG Image|*.jpg";
                saveDialog.FileName =
                    "Capture_" +
                    DateTime.Now.ToString("yyyyMMdd_HHmmss") +
                    ".jpg";

                if (saveDialog.ShowDialog() == DialogResult.OK)
                {
                    try
                    {
                        capturedImage.Save(
                            saveDialog.FileName,
                            ImageFormat.Jpeg
                        );

                        MessageBox.Show(
                            "Image saved successfully!"
                        );

                        lblStatus.Text = "Status: Image saved";
                    }
                    catch (Exception ex)
                    {
                        MessageBox.Show(ex.Message);
                    }
                }
            }
        }

        // Menghentikan kamera
        private void BtnStop_Click(object sender, EventArgs e)
        {
            StopCamera();
            lblStatus.Text = "Status: Camera stopped";
        }

        private void StopCamera()
        {
            if (videoSource != null)
            {
                videoSource.NewFrame -= VideoSource_NewFrame;

                if (videoSource.IsRunning)
                {
                    videoSource.SignalToStop();
                    videoSource.WaitForStop();
                }

                videoSource = null;
            }

            btnStart.Enabled = true;
        }

        // Membersihkan resource ketika aplikasi ditutup
        private void Form1_FormClosing(
            object sender,
            FormClosingEventArgs e)
        {
            StopCamera();

            pictureBoxLive.Image?.Dispose();
            pictureBoxCapture.Image?.Dispose();
            capturedImage?.Dispose();
        }
    }
}