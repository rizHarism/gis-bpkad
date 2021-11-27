/* global L */

/**
 * @name sidebarV2
 * @class L.Control.sidebarV2
 * @extends L.Control
 * @param {string} id - The id of the sidebarV2 element (without the # character)
 * @param {Object} [options] - Optional options object
 * @param {string} [options.position=left] - Position of the sidebarV2: 'left' or 'right'
 * @see L.control.sidebarV2
 */
L.Control.sidebarV2 = L.Control.extend(/** @lends L.Control.sidebarV2.prototype */ {
    includes: (L.Evented.prototype || L.Mixin.Events),

    options: {
        position: 'left'
    },

    initialize: function (id, options) {
        var i, child;

        L.setOptions(this, options);

        // Find sidebarV2 HTMLElement
        this._sidebarV2 = L.DomUtil.get(id);

        // Attach .sidebarV2-left/right class
        L.DomUtil.addClass(this._sidebarV2, 'sidebarV2-' + this.options.position);

        // Attach touch styling if necessary
        if (L.Browser.touch)
            L.DomUtil.addClass(this._sidebarV2, 'leaflet-touch');

        // Find sidebarV2 > div.sidebarV2-content
        for (i = this._sidebarV2.children.length - 1; i >= 0; i--) {
            child = this._sidebarV2.children[i];
            if (child.tagName == 'DIV' &&
                L.DomUtil.hasClass(child, 'sidebarV2-content'))
                this._container = child;
        }

        // Find sidebarV2 ul.sidebarV2-tabs > li, sidebarV2 .sidebarV2-tabs > ul > li
        this._tabitems = this._sidebarV2.querySelectorAll('ul.sidebarV2-tabs > li, .sidebarV2-tabs > ul > li');
        for (i = this._tabitems.length - 1; i >= 0; i--) {
            this._tabitems[i]._sidebarV2 = this;
        }

        // Find sidebarV2 > div.sidebarV2-content > div.sidebarV2-pane
        this._panes = [];
        this._closeButtons = [];
        for (i = this._container.children.length - 1; i >= 0; i--) {
            child = this._container.children[i];
            if (child.tagName == 'DIV' &&
                L.DomUtil.hasClass(child, 'sidebarV2-pane')) {
                this._panes.push(child);

                var closeButtons = child.querySelectorAll('.sidebarV2-close');
                for (var j = 0, len = closeButtons.length; j < len; j++)
                    this._closeButtons.push(closeButtons[j]);
            }
        }
    },

    /**
     * Add this sidebarV2 to the specified map.
     *
     * @param {L.Map} map
     * @returns {sidebarV2}
     */
    addTo: function (map) {
        var i, child;

        this._map = map;

        for (i = this._tabitems.length - 1; i >= 0; i--) {
            child = this._tabitems[i];
            var sub = child.querySelector('a');
            if (sub.hasAttribute('href') && sub.getAttribute('href').slice(0, 1) == '#') {
                L.DomEvent
                    .on(sub, 'click', L.DomEvent.preventDefault)
                    .on(sub, 'click', this._onClick, child);
            }
        }

        for (i = this._closeButtons.length - 1; i >= 0; i--) {
            child = this._closeButtons[i];
            L.DomEvent.on(child, 'click', this._onCloseClick, this);
        }

        return this;
    },

    /**
     * @deprecated - Please use remove() instead of removeFrom(), as of Leaflet 0.8-dev, the removeFrom() has been replaced with remove()
     * Removes this sidebarV2 from the map.
     * @param {L.Map} map
     * @returns {sidebarV2}
     */
    removeFrom: function (map) {
        console.log('removeFrom() has been deprecated, please use remove() instead as support for this function will be ending soon.');
        this.remove(map);
    },

    /**
     * Remove this sidebarV2 from the map.
     *
     * @param {L.Map} map
     * @returns {sidebarV2}
     */
    remove: function (map) {
        var i, child;

        this._map = null;

        for (i = this._tabitems.length - 1; i >= 0; i--) {
            child = this._tabitems[i];
            L.DomEvent.off(child.querySelector('a'), 'click', this._onClick);
        }

        for (i = this._closeButtons.length - 1; i >= 0; i--) {
            child = this._closeButtons[i];
            L.DomEvent.off(child, 'click', this._onCloseClick, this);
        }

        return this;
    },

    /**
     * Open sidebarV2 (if necessary) and show the specified tab.
     *
     * @param {string} id - The id of the tab to show (without the # character)
     */
    open: function (id) {
        var i, child;

        // hide old active contents and show new content
        for (i = this._panes.length - 1; i >= 0; i--) {
            child = this._panes[i];
            if (child.id == id)
                L.DomUtil.addClass(child, 'active');
            else if (L.DomUtil.hasClass(child, 'active'))
                L.DomUtil.removeClass(child, 'active');
        }

        // remove old active highlights and set new highlight
        for (i = this._tabitems.length - 1; i >= 0; i--) {
            child = this._tabitems[i];
            if (child.querySelector('a').hash == '#' + id)
                L.DomUtil.addClass(child, 'active');
            else if (L.DomUtil.hasClass(child, 'active'))
                L.DomUtil.removeClass(child, 'active');
        }

        this.fire('content', { id: id });

        // open sidebarV2 (if necessary)
        if (L.DomUtil.hasClass(this._sidebarV2, 'collapsed')) {
            this.fire('opening');
            L.DomUtil.removeClass(this._sidebarV2, 'collapsed');
        }

        return this;
    },

    /**
     * Close the sidebarV2 (if necessary).
     */
    close: function () {
        // remove old active highlights
        for (var i = this._tabitems.length - 1; i >= 0; i--) {
            var child = this._tabitems[i];
            if (L.DomUtil.hasClass(child, 'active'))
                L.DomUtil.removeClass(child, 'active');
        }

        // close sidebarV2
        if (!L.DomUtil.hasClass(this._sidebarV2, 'collapsed')) {
            this.fire('closing');
            L.DomUtil.addClass(this._sidebarV2, 'collapsed');
        }

        return this;
    },

    /**
     * @private
     */
    _onClick: function () {
        if (L.DomUtil.hasClass(this, 'active'))
            this._sidebarV2.close();
        else if (!L.DomUtil.hasClass(this, 'disabled'))
            this._sidebarV2.open(this.querySelector('a').hash.slice(1));
    },

    /**
     * @private
     */
    _onCloseClick: function () {
        this.close();
    }
});

/**
 * Creates a new sidebarV2.
 *
 * @example
 * var sidebarV2 = L.control.sidebarV2('sidebarV2').addTo(map);
 *
 * @param {string} id - The id of the sidebarV2 element (without the # character)
 * @param {Object} [options] - Optional options object
 * @param {string} [options.position=left] - Position of the sidebarV2: 'left' or 'right'
 * @returns {sidebarV2} A new sidebarV2 instance
 */
L.control.sidebarV2 = function (id, options) {
    return new L.Control.sidebarV2(id, options);
};
