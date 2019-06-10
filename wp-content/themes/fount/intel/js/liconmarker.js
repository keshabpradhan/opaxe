L.IconMarker = L.CircleMarker.extend({
  options: {
    className: 'circle',
    fillOpacity: 4,
    opacity: 0,
    weight: 0,
    display_size: 50
  },
  initialize: function(latlng, options) {

    L.Circle.prototype.initialize.call(this, latlng, null, options);
    this._latlng = L.latLng(latlng);
    this._radius = 0;
  },

  setStyle: function (style) {
    L.setOptions(this, style);

    if (this._container) {
      this._updateStyle();
    }
    if (this._container && _.get(style, 'className')) {
      this._updateShape(style.className);
    }

    return this;
  },

  _initPath: function () {
    var self = this;

    this._container = this._createElement('g');
    this._path = this._createElement('text');

    L.DomUtil.addClass(this._container, 'marker-group');
    L.DomUtil.addClass(this._path, 'marker-icon');

    this._container.appendChild(this._path);
    this._updateSize();
    this._updateShape(this.options.className);
  },

  _updatePath: function() { },

  _updateShape: function(className) {
    var content = IconContent[className];
    if (!content) {
      console.error('unable to create icon using className = ' + className);
      content = IconContent['circle'];
    }
    this.options.className = className;
    this._path.innerHTML = content;
  },

  _updateSize: function () {
    this._path.setAttribute('font-size', this.options.display_size);
    this._path.setAttribute('dy', this.options.display_size / 2 + 'px');
    this._path.setAttribute('dx', 0 - this.options.display_size / 2 + 'px');
  },

  projectLatlngs: function() {
    var point = this._map.latLngToLayerPoint(this._latlng);
    this._path.setAttribute('transform', 'translate(' +(point.x+1) + ',' + (point.y-1) + ')');
  },

});

L.iconMarker = function (latlng, options) {
  var marker = new L.IconMarker(latlng, options);
  return marker;
};




L.IconMarker2 = L.CircleMarker.extend({
  options: {
    className: 'circle',
    fillOpacity: 4,
    opacity: 0,
    weight: 0,
    display_size: 15
  },
  initialize: function(latlng, options) {

    L.Circle.prototype.initialize.call(this, latlng, null, options);
    this._latlng = L.latLng(latlng);
    this._radius = 0;
  },

  setStyle: function (style) {
    L.setOptions(this, style);

    if (this._container) {
      this._updateStyle();
    }
    if (this._container && _.get(style, 'className')) {
      this._updateShape(style.className);
    }

    return this;
  },

  _initPath: function () {
    var self = this;

    this._container = this._createElement('g');
    this._path = this._createElement('text');

    L.DomUtil.addClass(this._container, 'marker-group');
    L.DomUtil.addClass(this._path, 'marker-icon');

    this._container.appendChild(this._path);
    this._updateSize();
    this._updateShape(this.options.className);
  },

  _updatePath: function() { },

  _updateShape: function(className) {
    var content = IconContent[className];
    if (!content) {
      console.error('unable to create icon using className = ' + className);
      content = IconContent['circle'];
    }
    this.options.className = className;
    this._path.innerHTML = content;
  },

  _updateSize: function () {
    this._path.setAttribute('font-size', this.options.display_size);
    this._path.setAttribute('dy', this.options.display_size / 2 + 'px');
    this._path.setAttribute('dx', 0 - this.options.display_size / 2 + 'px');
  },

  projectLatlngs: function() {
    var point = this._map.latLngToLayerPoint(this._latlng);
    this._path.setAttribute('transform', 'translate(' +(point.x-7) + ',' + (point.y-3) + ')');
  },

});

L.iconMarker2 = function (latlng, options) {
  var marker = new L.IconMarker2(latlng, options);
  return marker;
};


