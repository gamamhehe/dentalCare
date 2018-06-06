<<<<<<< HEAD
jvm.SVGPathElement = function(config, style){
  jvm.SVGPathElement.parentClass.call(this, 'path', config, style);
  this.node.setAttribute('fill-rule', 'evenodd');
}

=======
jvm.SVGPathElement = function(config, style){
  jvm.SVGPathElement.parentClass.call(this, 'path', config, style);
  this.node.setAttribute('fill-rule', 'evenodd');
}

>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de
jvm.inherits(jvm.SVGPathElement, jvm.SVGShapeElement);