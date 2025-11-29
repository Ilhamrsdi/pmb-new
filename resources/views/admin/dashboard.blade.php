@extends('layouts.master')
@section('title')
  Dashboard
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboards
    @endslot
    @slot('title')
      Administrator
    @endslot
  @endcomponent

  {{-- Row 1: Statistic Cards (Full Width) --}}
  <div class="row">
    <div class="col-xl-4">
      <div class="card card-animate">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="avatar-sm flex-shrink-0">
              <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                <i data-feather="user" class="text-primary"></i>
              </span>
            </div>
            <div class="flex-grow-1 overflow-hidden ms-3">
              <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Pendaftar</p>
              <div class="d-flex align-items-center mb-3">
                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                    data-target="{{ $data['total_pendaftar'] }}">0</span></h4>
              </div>
              <p class="text-muted text-truncate mb-0">Orang</p>
            </div>
          </div>
        </div><!-- end card body -->
      </div>
    </div><!-- end col -->

    <div class="col-xl-4">
      <div class="card card-animate">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="avatar-sm flex-shrink-0">
              <span class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
                <i data-feather="dollar-sign" class="text-warning"></i>
              </span>
            </div>
            <div class="flex-grow-1 ms-3">
              <p class="text-uppercase fw-medium text-muted mb-3">Belum Bayar Pendaftaran</p>
              <div class="d-flex align-items-center mb-3">
                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                    data-target="{{ $data['total_belum_bayar_pendaftaran'] }}">0</span></h4>
              </div>
              <p class="text-muted mb-0">Orang</p>
            </div>
          </div>
        </div><!-- end card body -->
      </div>
    </div><!-- end col -->

    <div class="col-xl-4">
      <div class="card card-animate">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="avatar-sm flex-shrink-0">
              <span class="avatar-title bg-soft-danger text-danger rounded-2 fs-2">
                <i data-feather="credit-card" class="text-danger"></i>
              </span>
            </div>
            <div class="flex-grow-1 ms-3">
              <p class="text-uppercase fw-medium text-muted mb-3">Belum Bayar UKT</p>
              <div class="d-flex align-items-center mb-3">
                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                    data-target="{{ $data['total_belum_bayar_ukt'] }}">0</span></h4>
              </div>
              <p class="text-muted mb-0">Orang</p>
            </div>
          </div>
        </div><!-- end card body -->
      </div>
    </div><!-- end col -->
  </div><!-- end row 1 (Statistic Cards) -->

  {{-- Row 2: Charts (Split 70/30) --}}
  <div class="row">
    {{-- Chart 1: Bar Chart Tahunan (Lebih Besar) --}}
    <div class="col-xxl-8 col-lg-7">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center d-flex justify-content-between">
            <div class="col-6 col-md-6">
              <h4 class="card-title mb-0 flex-grow-1">Grafik Pendaftar Berdasarkan Tahun</h4>
            </div>
            <div class="col-6 col-md-4 text-end">
              <select name="tahun" id="tahun" class="form-select form-select-sm" onchange="updateChartSetahun()"></select>
            </div>
          </div>
        </div><!-- end card header -->
        <div class="card-body p-0 pb-2">
          <div>
            <div id="grafik-tahunan" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
              dir="ltr"></div>
          </div>
        </div><!-- end card body -->
      </div><!-- end card -->
    </div><!-- end col -->

    {{-- Chart 2: Donut Chart Bulanan (Ringkasan) --}}
    <div class="col-xxl-4 col-lg-5">
      <div class="card card-height-100">
        <div class="card-header align-items-center d-flex">
          <div class="row align-items-center d-flex justify-content-between w-100">
            <div class="col-6">
              <h4 class="card-title mb-0 flex-grow-1">Grafik Pendaftar Bulanan</h4>
            </div>
            <div class="col-6 text-end">
              <input type="month" id="filter" class="form-control form-control-sm" placeholder="Pilih Bulan"
                value="{{ Carbon\Carbon::parse(now())->format('Y-m') }}" onchange="updateChartSebulan()">
            </div>
          </div>
        </div><!-- end card header -->
        <div class="card-body">
          <div id="grafik-bulanan" data-colors='["--vz-success", "--vz-primary", "--vz-warning", "--vz-danger"]'
            class="apex-charts" dir="ltr"></div>
          <div class="mt-3">
            <div class="d-flex justify-content-center align-items-center mb-4">
              <h2 class="me-3 ff-secondary mb-0" id="total-pendaftar"></h2>
              <div>
                <p class="text-muted mb-0">Total Pendaftar Bulan Ini</p>
              </div>
            </div>

            {{-- Status List --}}
            <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
              <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-success align-middle me-2"></i>
                Maba Diterima</p>
              <div>
                <span class="text-muted pe-1 fw-bold" id="maba-diterima"></span>
              </div>
            </div><!-- end -->
            <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
              <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-primary align-middle me-2"></i>
                Maba Belum Diterima</p>
              <div>
                <span class="text-muted pe-1 fw-bold" id="maba-belum-diterima"></span>
              </div>
            </div><!-- end -->
            <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
              <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-warning align-middle me-2"></i>
                Belum Bayar Pendaftaran</p>
              <div>
                <span class="text-muted pe-1 fw-bold" id="belum-bayar-pendaftaran"></span>
              </div>
            </div><!-- end -->
            <div class="d-flex justify-content-between py-2">
              <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i>
                Belum Bayar UKT</p>
              <div>
                <span class="text-muted pe-1 fw-bold" id="belum-bayar-ukt"></span>
              </div>
            </div><!-- end -->
          </div>
        </div><!-- end cardbody -->
      </div><!-- end card -->
    </div><!-- end col -->
  </div><!-- end row 2 (Charts) -->

  {{-- Row 3: Data Pendaftar Terbaru (New Widget) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Data 10 Pendaftar Terbaru</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless table-hover table-centered align-middle table-nowrap mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col">Nama Pendaftar</th>
                  <th scope="col">Gelombang</th>
                  <th scope="col">Tgl Daftar</th>
                  <th scope="col">Status Pembayaran</th>
                  <th scope="col">Status Penerimaan</th>
                </tr>
              </thead>
              <tbody>
                {{-- Placeholder untuk data pendaftar terbaru (Ganti dengan looping data yang sebenarnya) --}}
                <tr>
                  <td><a href="#" class="fw-medium">Ahmad Sulaiman</a></td>
                  <td>Gelombang 2 (2025)</td>
                  <td>20 Nov 2024</td>
                  <td><span class="badge bg-success-subtle text-success">Lunas</span></td>
                  <td><span class="badge bg-primary-subtle text-primary">Proses Seleksi</span></td>
                </tr>
                <tr>
                  <td><a href="#" class="fw-medium">Bunga Citra</a></td>
                  <td>Gelombang 2 (2025)</td>
                  <td>19 Nov 2024</td>
                  <td><span class="badge bg-warning-subtle text-warning">Menunggu Verifikasi</span></td>
                  <td><span class="badge bg-danger-subtle text-danger">Belum Tuntas</span></td>
                </tr>
                <tr>
                  <td><a href="#" class="fw-medium">Cahyo Pratama</a></td>
                  <td>Gelombang 1 (2025)</td>
                  <td>15 Okt 2024</td>
                  <td><span class="badge bg-success-subtle text-success">Lunas</span></td>
                  <td><span class="badge bg-success-subtle text-success">Diterima</span></td>
                </tr>
                {{-- End Placeholder --}}
                <tr>
                    <td colspan="5" class="text-center">
                        <a href="#" class="link-primary text-decoration-underline">Lihat Semua Data Pendaftar</a>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- end row 3 (Latest Data) -->

@endsection

@section('script')
  <!-- apexcharts -->
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  {{-- Grafik --}}
  <script>
    var total_pendaftar = document.getElementById('total-pendaftar')
    var maba_diterima = document.getElementById('maba-diterima')
    var maba_belum_diterima = document.getElementById('maba-belum-diterima')
    var belum_bayar_pendaftaran = document.getElementById('belum-bayar-pendaftaran')
    var belum_bayar_ukt = document.getElementById('belum-bayar-ukt')
    var chart, chart2; // Deklarasi chart di scope atas

    // Setting Color
    function getChartColorsArray(e) {
      if (null !== document.getElementById(e)) {
        var t = document.getElementById(e).getAttribute("data-colors");
        if (t)
          return (t = JSON.parse(t)).map(function(e) {
            var t = e.replace(" ", "");
            if (-1 === t.indexOf(",")) {
              var r = getComputedStyle(
                document.documentElement
              ).getPropertyValue(t);
              return r || t;
            }
            e = e.split(",");
            return 2 != e.length ?
              t :
              "rgba(" +
              getComputedStyle(
                document.documentElement
              ).getPropertyValue(e[0]) +
              "," +
              e[1] +
              ")";
          });
        console.warn("data-colors Attribute not found on:", e);
      }
    }

    async function getGrafikSetahun(value) {
      let url = "{{ route('grafik-setahun') }}?tahun=" + value

      try {
        let res = await fetch(url);
        return await res.json();
      } catch (error) {
        console.error("Error fetching annual chart data:", error);
      }
    }

    async function renderChartSetahun() {
      let selectElement = document.getElementById('tahun');
      let value = selectElement.value;
      let data = await getGrafikSetahun(value);

      console.log("Annual Data:", data);

      var linechartcustomerColors = getChartColorsArray("grafik-tahunan");
      linechartcustomerColors &&
        ((options = {
            series: [{
                name: "Total Pendaftar",
                type: "bar",
                data: data.pendaftar,
              },
              {
                name: "Maba Diterima",
                type: "bar",
                data: data.diterima,
              },
              {
                name: "Maba Belum Diterima",
                type: "bar",
                data: data.belum_diterima,
              },
            ],
            chart: {
              height: 380, // Disesuaikan untuk layout baru
              type: "line",
              toolbar: {
                show: !1
              }
            },
            xaxis: {
              categories: [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
              ],
              axisTicks: {
                show: !1
              },
              axisBorder: {
                show: !1
              },
            },
            grid: {
              show: !0,
              xaxis: {
                lines: {
                  show: !0
                }
              },
              yaxis: {
                lines: {
                  show: !1
                }
              },
              padding: {
                top: 10,
                right: 5,
                bottom: 15,
                left: 10
              },
            },
            legend: {
              show: !0,
              horizontalAlign: "center",
              offsetX: 0,
              offsetY: -5,
              markers: {
                width: 9,
                height: 9,
                radius: 6
              },
              itemMargin: {
                horizontal: 10,
                vertical: 0
              },
            },
            plotOptions: {
              bar: {
                columnWidth: "50%", // Disesuaikan agar lebih tebal
                borderRadius: 4,
                dataLabels: {
                    position: 'top',
                }
              }
            },
            dataLabels: {
                enabled: false,
            },
            colors: linechartcustomerColors,
            tooltip: {
              shared: !0,
              y: [{
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
                {
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
                {
                  formatter: function(e) {
                    return void 0 !== e ? e.toFixed(0) : e;
                  },
                },
              ],
            },
          }),
          (chart = new ApexCharts(
            document.querySelector("#grafik-tahunan"),
            options
          )).render());
    }

    async function updateChartSetahun() {
      let value = document.getElementById('tahun').value;
      let data = await getGrafikSetahun(value);

      if (chart && data) {
        console.log("Updating Annual Chart with data:", data);
        chart.updateSeries([{
            name: "Total Pendaftar",
            type: "bar",
            data: data.pendaftar,
          },
          {
            name: "Maba Diterima",
            type: "bar",
            data: data.diterima,
          },
          {
            name: "Maba Belum Diterima",
            type: "bar",
            data: data.belum_diterima,
          },
        ]);
      }
    }

    async function getGrafikSebulan(value) {
      let url = "{{ route('grafik-sebulan') }}?filter=" + value

      try {
        let res = await fetch(url);
        return await res.json();
      } catch (error) {
        console.error("Error fetching monthly chart data:", error);
      }
    }

    async function renderChartSebulan() {
      let value = document.getElementById('filter').value;
      let data = await getGrafikSebulan(value);

      if (!data) return; // Guard clause

      console.log("Monthly Data:", data);

      // Update text statistics
      total_pendaftar.textContent = data[0] || '0'
      maba_diterima.textContent = data[1] || '0'
      maba_belum_diterima.textContent = data[2] || '0'
      belum_bayar_pendaftaran.textContent = data[3] || '0'
      belum_bayar_ukt.textContent = data[4] || '0'

      // Prepare data for Donut Chart (remove total pendaftar)
      let chartData = data.slice(1);
      
      var options,
        donutchartProjectsStatusColors = getChartColorsArray("grafik-bulanan");

      donutchartProjectsStatusColors &&
        ((options = {
            series: chartData,
            labels: ["Maba Diterima", "Belum Diterima", "Belum Bayar Pendaftaran", "Belum Bayar UKT"],
            chart: {
              type: "donut",
              height: 250 // Disesuaikan untuk layout baru
            },
            plotOptions: {
              pie: {
                size: 100,
                offsetX: 0,
                offsetY: 0,
                donut: {
                  size: "85%", // Disesuaikan agar lebih ringkas
                  labels: {
                    show: !1
                  }
                },
              },
            },
            dataLabels: {
              enabled: !1
            },
            legend: {
              show: !1
            },
            stroke: {
              lineCap: "round",
              width: 0
            },
            colors: donutchartProjectsStatusColors,
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + " Orang";
                    }
                }
            }
          }),
          (chart2 = new ApexCharts(
            document.querySelector("#grafik-bulanan"),
            options
          )).render());
    }

    async function updateChartSebulan() {
      let value = document.getElementById('filter').value;
      let data = await getGrafikSebulan(value);

      if (!data || !chart2) return; // Guard clause

      console.log("Updating Monthly Chart with data:", data);

      // Update text statistics
      total_pendaftar.textContent = data[0] || '0'
      maba_diterima.textContent = data[1] || '0'
      maba_belum_diterima.textContent = data[2] || '0'
      belum_bayar_pendaftaran.textContent = data[3] || '0'
      belum_bayar_ukt.textContent = data[4] || '0'

      // Prepare data for Donut Chart (remove total pendaftar)
      let chartData = data.slice(1);

      chart2.updateSeries(chartData);
    }

    // Initialize Charts
    document.addEventListener('DOMContentLoaded', () => {
        renderChartSetahun();
        renderChartSebulan();
    });
  </script>

  <script>
    // Inisialisasi Tahun Dropdown
    $(document).ready(function() {
        let startYear = 2020; // Tahun awal yang realistis
        let endYear = new Date().getFullYear() + 1; // Tahun sekarang + 1
        let currentYear = new Date().getFullYear();

        for (i = endYear; i >= startYear; i--) {
            $('#tahun').append($('<option />').val(i).html(i));
        }
        // Set tahun default ke tahun sekarang
        $('#tahun').val(currentYear).trigger('change'); 
    });
  </script>

  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection