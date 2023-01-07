@php
    //dados para o 1º chart
    $lastYearRegistrations = [];
    for($month = 11; $month >= 0 ; $month--){
        $startDate = \Carbon\Carbon::today()->subMonths($month + 1);
        $endDate = \Carbon\Carbon::today()->subMonths($month);
        $AssociatesCreatedAt = \App\Models\Associate::whereDate('registration_date','>=',$startDate)->whereDate('created_at','<',$endDate)->count();
        $lastYearRegistrations[] = [
          'date1' => $startDate,
          'price1' => $AssociatesCreatedAt
        ];
    }

    //dados para o 2º chart
    $associadosEfetivos =  \App\Models\Associate::where('category',\App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)->count();
    $associadosAderentes =  \App\Models\Associate::where('category',\App\Models\Associate::CATEGORY_ASSOCIADO_ADERENTE)->count();
    $associadosEstudantes =  \App\Models\Associate::where('category',\App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)->count();
    $associadosHonorario =  \App\Models\Associate::where('category',\App\Models\Associate::CATEGORY_MEMBRO_HONORARIO)->count();

    //dados para o 3º chart
    $associatesCount = \App\Models\Associate::whereIn('category',[\App\Models\Associate::CATEGORY_ASSOCIADO_ADERENTE,\App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO])->whereNotNull('quota_valid_until')->count();
    $associatesWithPayedQuotas = \App\Models\Associate::whereIn('category',[\App\Models\Associate::CATEGORY_ASSOCIADO_ADERENTE,\App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO])->whereNotNull('quota_valid_until')->whereDate('quota_valid_until','>=',\Carbon\Carbon::now())->count();
    $associatesWithNoPayedQuotas = $associatesCount - $associatesWithPayedQuotas;

    //dados para o 4º chart
    $alvara = \App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id',1)->count();
    $projeto = \App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id',2)->count();
    $concurso = \App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id',9)->count();
    $seguro = \App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id',8)->count();
    $estrangeiras = \App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_ACTIVE)->whereIn('declaration_template_id',[3,4,5,6,7])->count();
@endphp

@push('scripts')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script>
        am4core.ready(function () {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart 1
            chart1 = am4core.create('kt_amcharts_2', am4charts.XYChart);
            chart1.data = {!! json_encode($lastYearRegistrations) !!};

            var dateAxis = chart1.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.labels.template.fill = am4core.color('#e59165');

            var valueAxis = chart1.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.labels.template.fill = am4core.color('#e59165');

            valueAxis.renderer.minWidth = 60;

            var series = chart1.series.push(new am4charts.LineSeries());
            series.name = 'Inscrição de Associados no Último Ano';
            series.dataFields.dateX = 'date1';
            series.dataFields.valueY = 'price1';
            series.tooltipText = '{valueY.value}';
            series.fill = am4core.color('#e59165');
            series.stroke = am4core.color('#e59165');
            //series.strokeWidth = 3;
            //series.columns.template.width = am4core.percent(100);


            var scrollbarX = new am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            chart1.scrollbarX = scrollbarX;

            chart1.legend = new am4charts.Legend();
            chart1.legend.parent = chart1.plotContainer;
            chart1.legend.zIndex = 100;

            dateAxis.renderer.grid.template.strokeOpacity = 0.07;
            valueAxis.renderer.grid.template.strokeOpacity = 0.07;

            //end chart 1


            //create chart 2

            var chart2 = am4core.create('kt_amcharts_1', am4charts.XYChart)
            chart2.colors.step = 2;

            chart2.legend = new am4charts.Legend()
            chart2.legend.position = 'top'
            chart2.legend.paddingBottom = 20
            chart2.legend.labels.template.maxWidth = 95

            var xAxis2 = chart2.xAxes.push(new am4charts.CategoryAxis())
            xAxis2.dataFields.category = 'category'
            xAxis2.renderer.cellStartLocation = 0.1
            xAxis2.renderer.cellEndLocation = 0.9
            xAxis2.renderer.grid.template.location = 0;

            var yAxis2 = chart2.yAxes.push(new am4charts.ValueAxis());
            yAxis2.min = 0;

            function createSeries2(value, name) {
                var series2 = chart2.series.push(new am4charts.ColumnSeries())
                series2.dataFields.valueY = value
                series2.dataFields.categoryX = 'category'
                series2.name = name

                series2.events.on('hidden', arrangeColumns);
                series2.events.on('shown', arrangeColumns);

                var bullet2 = series2.bullets.push(new am4charts.LabelBullet())
                bullet2.interactionsEnabled = false
                bullet2.dy = 30;
                bullet2.label.text = '{valueY}'
                bullet2.label.fill = am4core.color('#ffffff')

                return series2;
            }

            chart2.data = [
                {
                    category: '2021',
                    first: {!! json_encode($associadosEfetivos) !!},
                    second: {!! json_encode($associadosAderentes) !!},
                    third: {!! json_encode($associadosEstudantes) !!},
                    fourth: {!! json_encode($associadosHonorario) !!},
                    color: '#67b7dc'
                },
            ]


            createSeries2('first', 'Efetivo');
            createSeries2('second', 'Aderente');
            createSeries2('third', 'Estudante');
            createSeries2('fourth', 'Honorário');

            function arrangeColumns() {

                var series = chart2.series.getIndex(0);

                var w = 1 - xAxis2.renderer.cellStartLocation - (1 - xAxis2.renderer.cellEndLocation);

                if (series.dataItems.length > 1) {
                    var x0 = xAxis2.getX(series.dataItems.getIndex(0), 'categoryX');
                    var x1 = xAxis2.getX(series.dataItems.getIndex(1), 'categoryX');
                    var delta = ((x1 - x0) / chart2.series.length) * w;
                    if (am4core.isNumber(delta)) {
                        var middle = chart2.series.length / 2;

                        var newIndex = 0;
                        chart2.series.each(function (series) {
                            if (!series.isHidden && !series.isHiding) {
                                series.dummyData = newIndex;
                                newIndex++;
                            }
                            else {
                                series.dummyData = chart2.series.indexOf(series);
                            }
                        })
                        var visibleCount = newIndex;
                        var newMiddle = visibleCount / 2;

                        chart2.series.each(function (series) {
                            var trueIndex = chart2.series.indexOf(series);
                            var newIndex = series.dummyData;

                            var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                            series.animate({ property: 'dx', to: dx }, series.interpolationDuration, series.interpolationEasing);
                            series.bulletsContainer.animate({ property: 'dx', to: dx }, series.interpolationDuration, series.interpolationEasing);
                        })
                    }
                }
            }

            // end chart 2

            //create chart 3

//create chart 4
            chart3 = am4core.create('kt_amcharts_3', am4charts.PieChart);

            chart3.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart3.data = [
                {
                    country: 'Com situação regularizada',
                    value: {!! $associatesWithPayedQuotas !!}
                },
                {
                    country: 'Com situação irregular',
                    value: {!! $associatesWithNoPayedQuotas !!}
                },
            ];
            //chart3.hideCredits = true;

            var series3 = chart3.series.push(new am4charts.PieSeries());
            series3.dataFields.value = 'value';
            series3.dataFields.radiusValue = 'value';
            series3.dataFields.category = 'country';
            series3.slices.template.cornerRadius = 6;
            series3.colors.step = 3;
            series3.labels.template.disabled = true;
            //series3.tooltip.disabled = true;
            //series3.labels.template.maxWidth = 100;
            /*series3.labels.template.wrap = true;
            series3.labels.template.oversizedBehavior = "wrap";
            series3.labels.alignLabels = false;*/
            series3.hiddenState.properties.endAngle = -90;

            chart3.legend = new am4charts.Legend();
            chart3.legend.labels.template.truncate = true;


            //end chart 3

            //create chart 4
            chart4 = am4core.create('kt_amcharts_4', am4charts.PieChart);
            chart4.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart4.data = [
                {
                    country: 'Alvará',
                    value: {!! $alvara !!}
                },
                {
                    country: 'Projeto',
                    value: {!! $projeto !!}
                },
                {
                    country: 'Concurso',
                    value: {!! $concurso !!}
                },
                {
                    country: 'Seguro',
                    value: {!! $seguro !!}
                },
                {
                    country: 'Estrangeiras',
                    value: {!! $estrangeiras !!}
                },
            ];

            var series4 = chart4.series.push(new am4charts.PieSeries());
            series4.dataFields.value = 'value';
            series4.dataFields.radiusValue = 'value';
            series4.dataFields.category = 'country';
            series4.slices.template.cornerRadius = 6;
            series4.colors.step = 3;

            series4.hiddenState.properties.endAngle = -90;
            series4.labels.template.disabled = true;
            chart4.legend = new am4charts.Legend();
            chart4.legend.labels.template.truncate = true;
            chart4.legend.labels.template.wrap = true;
            // end chart 4
$('g:has(> g[stroke="#3cabff"])').hide();
            /*console.log($('g[aria-labelledby="id-670-title"]'));
            $('g[aria-labelledby="id-670-title"]').hide();*/
        }); // end am4core.ready()

    </script>
@endpush
<div class="row">
    <div class="col-6 card px-2">
        <div class="card-header">
            <h3 class="card-title">Inscrição de Associados no Último Ano</h3>
        </div>
        <div class="card-body">
            <div id="kt_amcharts_2" style="height: 500px;"></div>
        </div>
    </div>
    <div class="col-6 card px-2">
        <div class="card-header">
            <h3 class="card-title">Tipo de Associados Inscritos</h3>
        </div>
        <div class="card-body">
            <div id="kt_amcharts_1" style="height: 500px;"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 card px-2">
        <div class="card-header">
            <h3 class="card-title">Situação de Quotas de Associados</h3>
        </div>

        <div class="card-body">
            <div id="kt_amcharts_3" style="height: 500px;"></div>
        </div>
    </div>
    <div class="col-6 card px-2">
        <div class="card-header">
            <h3 class="card-title">Tipos de Declarações Emitidas no Último Ano</h3>
        </div>
        <div class="card-body">
            <div id="kt_amcharts_4" style="height: 500px;"></div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        g[aria-labelledby="id-645-title"]{
            display: none;
        }
        g[aria-labelledby="id-558-title"]{
            display: none;
        }
        g[aria-labelledby="id-66-title"]{
            display: none;
        }
        g[aria-labelledby="id-355-title"]{
            display: none;
        }
    </style>
@endpush
