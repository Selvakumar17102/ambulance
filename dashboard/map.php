<?php
    include('include/connection.php');
    ini_set('display_errors', 'off');

    $blood_requests = array();
    $ambulance_requests = array();
    $month_names = array();
    $total_requests = 0;
    
    for($i=1; $i<=12; $i++){
        $currentYear = date('Y');
        $firstDate = date('Y-m-d', strtotime($currentYear.'-'.$i.'-01'));
        $lastDate = date('Y-m-t', strtotime($firstDate));
        $month = date('M', strtotime($firstDate));
        array_push($month_names, $month);

        $blood_req_sql = "SELECT * FROM blood_request WHERE request_date BETWEEN '$firstDate' AND '$lastDate'";
        $blood_req_result = $conn->query($blood_req_sql);
        $blood_req_value = $blood_req_result->num_rows;
        array_push($blood_requests, $blood_req_value);
        
        $ambulance_req_sql = "SELECT * FROM orders WHERE booking_date BETWEEN '$firstDate' AND '$lastDate'";
        $ambulance_req_result = $conn->query($ambulance_req_sql);
        $ambulance_req_value = $ambulance_req_result->num_rows;
        array_push($ambulance_requests, $ambulance_req_value);

        $total_request_value = $blood_req_value + $ambulance_req_value;
        $total_requests += $total_request_value;

        $total_request_blood += $blood_req_value;
        $total_request_ambulance += $ambulance_req_value;
        // echo $total_requests;

        // $count_array['all'][$i] = [
        //     'bloodReq_count' => $blood_req_row
        // ];
    }
    // print_r($blood_requests); exit();

    // // $blood_req = array_push($blood_req);
    // $blood_req = '['.rtrim($blood_req, ',').']';
    // $ambulance_req = '['.rtrim($ambulance_req, ',').']';
    // $monthValue = '['.rtrim($month, ',').']';
    // // $total_requests = '['.rtrim($total_requests, ',').']';
    //  print_r($blood_req);
    $blood_requests_array = json_encode($blood_requests);
    $ambulance_requests_array = json_encode($ambulance_requests);
    $monthValue = json_encode($month_names);
    print_r($total_requests);
?>
<script>
    try {
        var request_options = {
            chart: {
              fontFamily: 'Nunito, sans-serif',
              height: 365,
              type: 'area',
              zoom: {
                  enabled: false
              },
              dropShadow: {
                enabled: true,
                opacity: 0.2,
                blur: 10,
                left: -7,
                top: 22
              },
              toolbar: {
                show: false
              },
              events: {
                mounted: function(ctx, config) {
                  const highest1 = ctx.getHighestValueInSeries(0);
                  const highest2 = ctx.getHighestValueInSeries(1);
                
                  ctx.addPointAnnotation({
                    x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
                    y: highest1,
                    label: {
                      style: {
                        cssClass: 'd-none'
                      }
                    },
                    customSVG: {
                        SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                        cssClass: undefined,
                        offsetX: -8,
                        offsetY: 5
                    }
                  })
              
                  ctx.addPointAnnotation({
                    x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
                    y: highest2,
                    label: {
                      style: {
                        cssClass: 'd-none'
                      }
                    },
                    customSVG: {
                        SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                        cssClass: undefined,
                        offsetX: -8,
                        offsetY: 5
                    }
                  })
                },
              }
            },
            colors: ['#1b55e2', '#e7515a'],
            dataLabels: {
                enabled: false
            },
            markers: {
              discrete: [{
              seriesIndex: 0,
              dataPointIndex: 7,
              fillColor: '#000',
              strokeColor: '#000',
              size: 5
            }, {
              seriesIndex: 2,
              dataPointIndex: 11,
              fillColor: '#000',
              strokeColor: '#000',
              size: 4
            }]
            },
            subtitle: {
              text: '<?= $total_requests; ?>',
              align: 'left',
              margin: 0,
              offsetX: 95,
              offsetY: 0,
              floating: false,
              style: {
                fontSize: '18px',
                color:  '#4361ee'
              }
            },
            title: {
              text: 'Total',
              align: 'left',
              margin: 0,
              offsetX: -10,
              offsetY: 0,
              floating: false,
              style: {
                fontSize: '18px',
                color:  '#0e1726'
              },
            },
            stroke: {
                show: true,
                curve: 'smooth',
                width: 2,
                lineCap: 'square'
            },
            series: [{
                name: 'Blood',
                data: <?php echo $blood_requests_array; ?>
            }, {
                name: 'Ambulance',
                data: <?= $ambulance_requests_array; ?>
            }],
            labels: <?= $monthValue; ?>,
            xaxis: {
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },
              crosshairs: {
                show: true
              },
              labels: {
                offsetX: 0,
                offsetY: 5,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Nunito, sans-serif',
                    cssClass: 'apexcharts-xaxis-title',
                },
              }
            },
            yaxis: {
              labels: {
                formatter: function(value, index) {
                  return (value / 1000) + 'K'
                },
                offsetX: -22,
                offsetY: 0,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Nunito, sans-serif',
                    cssClass: 'apexcharts-yaxis-title',
                },
              }
            },
            grid: {
              borderColor: '#e0e6ed',
              strokeDashArray: 5,
              xaxis: {
                  lines: {
                      show: true
                  }
              },
              yaxis: {
                  lines: {
                      show: false,
                  }
              },
              padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: -10
              },
            },
            legend: {
              position: 'top',
              horizontalAlign: 'right',
              offsetY: -50,
              fontSize: '16px',
              fontFamily: 'Nunito, sans-serif',
              markers: {
                width: 10,
                height: 10,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: undefined,
                radius: 12,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
              },
              itemMargin: {
                horizontal: 0,
                vertical: 20
              }
            },
            tooltip: {
              theme: 'dark',
              marker: {
                show: true,
              },
              x: {
                show: false,
              }
            },
            fill: {
                type:"gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .28,
                    opacityTo: .05,
                    stops: [45, 100]
                }
            },
            responsive: [{
              breakpoint: 575,
              options: {
                legend: {
                    offsetY: -30,
                },
              },
            }]
        }
        console.log(request_options.series.data);

        /*
            ==============================
            |    Request Charts Script    |
            ==============================
        */

        var request_options_donut = {
            chart: {
                type: 'donut',
                width: 380
            },
            colors: ['#5c1ac3', '#e2a03f', '#e7515a', '#e2a03f'],
            dataLabels: {
              enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
                markers: {
                  width: 10,
                  height: 10,
                },
                itemMargin: {
                  horizontal: 0,
                  vertical: 8
                }
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '65%',
                  background: 'transparent',
                  labels: {
                    show: true,
                    name: {
                      show: true,
                      fontSize: '29px',
                      fontFamily: 'Nunito, sans-serif',
                      color: undefined,
                      offsetY: -10
                    },
                    value: {
                      show: true,
                      fontSize: '26px',
                      fontFamily: 'Nunito, sans-serif',
                      color: '20',
                      offsetY: 16,
                      formatter: function (val) {
                        return val
                      }
                    },
                    total: {
                      show: true,
                      showAlways: true,
                      label: 'Total',
                      color: '#888ea8',
                      formatter: function (w) {
                        return w.globals.seriesTotals.reduce( function(a, b) {
                          return a + b
                        }, 0)
                      }
                    }
                  }
                }
              }
            },
            stroke: {
              show: true,
              width: 25,
            },
            series: [<?= $total_request_blood; ?>, <?= $total_request_ambulance; ?>],
            labels: ['Blood', 'Ambulance'],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '350px',
                        height: '400px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '250px',
                        height: '390px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                      pie: {
                        donut: {
                          size: '65%',
                        }
                      }
                    }
                },
            }]
        }

        /*
            ==============================
            |    @Render Charts Script    |
            ==============================
        */


        /*
            ============================
                Daily Sales | Render
            ============================
        */
        // var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
        // d_2C_1.render();

        /*
            ============================
                Total Orders | Render
            ============================
        */
        // var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
        // d_2C_2.render();

        /*
            ================================
                Revenue Monthly | Render
            ================================
        */
        // var chart1 = new ApexCharts(
        //     document.querySelector("#revenueMonthly"),
        //     options1
        // );

        // chart1.render();

        /*
            =================================
                Sales By Category | Render
            =================================
        */
        // var chart = new ApexCharts(
        //     document.querySelector("#chart-2"),
        //     options
        // );

        // chart.render();

        /*
            =============================================
                Requests Details
            =============================================
        */
        var request_chart = new ApexCharts(
            document.querySelector("#requestMonthly"),
            request_options
        );

        request_chart.render();

        /*
            =============================================
                Requests Details
            =============================================
        */
        var request_chart_donut = new ApexCharts(
            document.querySelector("#requestDetails"),
            request_options_donut
        );

        request_chart_donut.render();

        /*
            =============================================
                Perfect Scrollbar | Recent Activities
            =============================================
        */
        const ps = new PerfectScrollbar(document.querySelector('.mt-container'));
    } catch(e) {
        // console.log(e);
    }
</script>