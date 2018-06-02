<<<<<<< HEAD
describe 'Morris.Grid#yLabelFormat', ->

  it 'should use custom formatter for y labels', ->
    formatter = (label) ->
      flabel = parseFloat(label) / 1000
      "#{flabel.toFixed(1)}k"
    line = Morris.Line
      element: 'graph'
      data: [{x: 1, y: 1500}, {x: 2, y: 2500}]
      xkey: 'x'
      ykeys: ['y']
      labels: ['dontcare']
      preUnits: "$"
      yLabelFormat: formatter
    line.yLabelFormat(1500).should.equal "1.5k"
=======
describe 'Morris.Grid#yLabelFormat', ->

  it 'should use custom formatter for y labels', ->
    formatter = (label) ->
      flabel = parseFloat(label) / 1000
      "#{flabel.toFixed(1)}k"
    line = Morris.Line
      element: 'graph'
      data: [{x: 1, y: 1500}, {x: 2, y: 2500}]
      xkey: 'x'
      ykeys: ['y']
      labels: ['dontcare']
      preUnits: "$"
      yLabelFormat: formatter
    line.yLabelFormat(1500).should.equal "1.5k"
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de
