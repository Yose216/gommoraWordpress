<?php
$options_string = '{
    "width": {
        "name": "Width",
        "slug": "width",
        "type": {
            "numeric": {
                "title": "Width",
                "style": "width",
                "property": "0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            }
        },
        "desc": "Change the default width of the current element."
    },
    "height": {
        "name": "Height",
        "slug": "height",
        "type": {
            "numeric": {
                "title": "Height",
                "style": "height",
                "property": "0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            }
        },
        "desc": "Change the default height of the current element."
    },
    "background": {
        "name": "Background",
        "slug": "background",
        "type": {
            "color-picker": {
                "title": "Background Color",
                "style": "background-color",
                "property": "#fff"
            },
            "input": {
                "title": "Background Image",
                "style": "background-image",
                "property": "none"
            },
            "select1": {
                "title": "Background Position",
                "style": "background-position",
                "property": [
                    "left top",
                    "left center",
                    "left bottom",
                    "center top",
                    "center center",
                    "center bottom",
                    "right top",
                    "right center",
                    "right bottom"
                ]
            },
            "select2": {
                "title": "Background Size",
                "style": "background-size",
                "property": [
                    "inherit",
                    "cover",
                    "contain"
                ]
            },
            "select3": {
                "title": "Background Repeat",
                "style": "background-repeat",
                "property": [
                    "no-repeat",
                    "repeat-x",
                    "repeat-y",
                    "repeat",
                    "space",
                    "round"
                ]
            },
            "select4": {
                "title": "Background Attachment",
                "style": "background-attachment",
                "property": [
                    "inherit",
                    "fixed",
                    "scroll",
                    "local"
                ]
            }
        },
        "desc": "Change the default background properties of the current element."
    },
    "border": {
        "name": "Border",
        "slug": "border",
        "type": {
            "numeric1": {
                "title": "Border Width",
                "style": "border-width",
                "property": "0 0 0 0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            },
            "select": {
                "title": "Border Style",
                "style": "border-style",
                "property": [
                    "none",
                    "solid",
                    "dotted",
                    "double",
                    "groove",
                    "ridge",
                    "inset",
                    "outset"
                ]
            },
            "color-picker": {
                "title": "Border color",
                "style": "border-color",
                "property": "#fff"
            },
            "numeric2": {
                "title": "Border radius",
                "style": "border-radius",
                "property": "0 0 0 0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            }
        },
        "desc": "Add custom border."
    },
    "font": {
        "name": "Font",
        "slug": "font",
        "type": {
            "numeric1": {
                "title": "Font size",
                "style": "font-size",
                "property": "0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            },
            "select2": {
                "title": "Font weight",
                "style": "font-weight",
                "property": [
                    "inherit",
                    "normal",
                    "bold",
                    "lighter",
                    "bolder",
                    "300",
                    "400",
                    "600",
                    "700"
                ]
            },
            "select1": {
                "title": "Font style",
                "style": "font-style",
                "property": [
                    "normal",
                    "italic",
                    "oblique"
                ]
            },
            "select4": {
                "title": "Text Align",
                "style": "text-align",
                "property": [
                    "left",
                    "right",
                    "center",
                    "justify",
                    "start",
                    "end"
                ]
            },
            "select3": {
                "title": "Text transform",
                "style": "text-transform",
                "property": [
                    "inherit",
                    "capitalize",
                    "uppercase",
                    "lowercase",
                    "none"
                ]
            },
            "select5": {
                "title": "Text decoration",
                "style": "text-decoration",
                "property": [
                    "none",
                    "underline",
                    "inherit",
                    "initial",
                    "unset"
                ]
            },
            "numeric2": {
                "title": "Line Height",
                "style": "line-height",
                "property": "0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            },

            "numeric3": {
                "title": "Text indent",
                "style": "text-indent",
                "property": "0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            },

            "color-picker": {
                "title": "Color",
                "style": "color",
                "property": "#fff"
            }
        },
        "desc": "Add custom font."
    },
    "margin": {
        "name": "Margin",
        "slug": "margin",
        "type": {
            "numeric": {
                "title": "Margin",
                "style": "margin",
                "property": "0 0 0 0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            }
        },
        "desc": "Add custom margin."
    },
    "padding": {
        "name": "Padding",
        "slug": "padding",
        "type": {
            "numeric": {
                "title": "Padding",
                "style": "padding",
                "property": "0 0 0 0",
                "unit": [
                    "px",
                    "%",
                    "em"
                ]
            }
        },
        "desc": "Add custom padding."
    },
    "float": {
        "name": "Position",
        "slug": "float",
        "type": {
            "select": {
                "title": "Position",
                "style": "float",
                "property": [
                    "inherit",
                    "none",
                    "left",
                    "right"
                ]
            }
        },
        "desc": "Add custom float."
    },
    "display": {
        "name": "Display",
        "slug": "display",
        "type": {
            "select": {
                "title": "Display",
                "style": "display",
                "property": [
                    "inherit",
                    "none",
                    "inline",
                    "inline-block",
                    "block"
                ]
            }
        },
        "desc": "Add custom display."
    },
    "box-sizing": {
        "name": "Box sizing",
        "slug": "box-sizing",
        "type": {
            "select": {
                "title": "Box sizing",
                "style": "box-sizing",
                "property": [
                    "inherit",
                    "initial",
                    "unset",
                    "content-box",
                    "border-box"
                ]
            }
        },
        "desc": "Add custom box sizing."
    },
    "comming-soon": {
        "name": "Comming Soon",
        "slug": "box-sizing",
        "type": {
            "comming-soon": {}
        }
    }
}';
