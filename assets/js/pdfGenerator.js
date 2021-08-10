function createSummaryReport() {

    let  content= [
        'pdfmake (since it\'s based on pdfkit) supports JPEG and PNG format',
     'If no width/height/fit is provided, image original size will be used',
     'test test',
     'You can also fit the image inside a rectangle'
     
   ];

    return content;
}

function downloadSummaryReport() {

    let  content= [
        'pdfmake (since it\'s based on pdfkit) supports JPEG and PNG format',
     'If no width/height/fit is provided, image original size will be used',
     'test test',
     'You can also fit the image inside a rectangle'
     
   ];
    let tableLayouts = {
        hLayout: {
            hLineWidth: function (i, node) {
                if (i === 0 || i === node.table.body.length) {
                    return 0;
                }
                return (i === node.table.headerRows) ? 2 : 0;
            },
            vLineWidth: function (i) {
                return 0;
            },
            hLineColor: function (i) {
                return i === 1 ? 'black' : '#aaa';
            },
            paddingLeft: function (i) {
                return i === 0 ? 0 : 2;
            },
            paddingRight: function (i, node) {
                return (i === node.table.widths.length - 1) ? 0 : 2;
            }
        }
    };

    var fonts = {
        CourierPrime: {
            normal: 'CourierPrime.ttf',
            bold: 'CourierPrimeBold.ttf',
            italics: 'CourierPrimeItalic.ttf',
            bolditalics: 'CourierPrimeBoldItalic.ttf'
        },
        Roboto: {
            normal: 'Roboto-Regular.ttf',
            bold: 'Roboto-Medium.ttf',
            italics: 'Roboto-Italic.ttf',
            bolditalics: 'Roboto-MediumItalic.ttf'
        }
    };
    var dd = {
        content: content,
        styles: {
            tableStyle1: {
                margin: [20, 5, 0, 5]
            },
            tableStyle2: {
                margin: [40, 5, 0, 15]
            },
            tableHeader: {
                bold: false,
                fontSize: 9,
                color: 'black'
            },
            tableHeaderObst: {
                bold: false,
                fontSize: 7.5,
                color: 'black'
            },
            tableData:
            {
                bold: false,
                fontSize: 9,
                color: 'black'
            },
            tableDataBold:
            {
                bold: false,
                fontSize: 7.5,
                color: 'black'
            },
            tableDef:
            {
                bold: false,
                fontSize: 9,
                margin: [10, 1],
                color: 'black'
            }
        }
       
       
    }

    var callbackFunction = function () {
        // Here implement function for hide waiting loader
       
    }
    // let airnavtableforpdf = table(airnavtabledata, ['anv', 'value']);
    let dfname = `Summary` + '.pdf'; //'SearchResult-' + new Date(Date.now()).toLocaleString().split(',')[0].split("/").join("-") + '.pdf';

    // pdfMake.createPdf(dd, null, fonts).download(dfname, callbackFunction);
    pdfMake.createPdf(dd, tableLayouts, fonts).download(dfname, callbackFunction);
}
