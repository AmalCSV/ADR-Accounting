function getOrderHeader( orderType, orderNumber, date) {
  let headerContent = [];

let title = {
    text: orderType,
    color: "#333333",
    width: "*",
    fontSize: 28,
    bold: true,
    alignment: "right",
    margin: [0, 0, 0, 15]
  }

  headerContent.push(title);

let stack = [];

let orderNo = {
    columns: [
      {
        text: "Order No",
        color: "#aaaaab",
        bold: true,
        width: "*",
        fontSize: 12,
        alignment: "right"
      }, {
        text: orderNumber,
        bold: true,
        color: "#333333",
        fontSize: 12,
        alignment: "right",
        width: 100
      }
    ]
  }

  stack.push(orderNo);

  let dateIssued = {
    columns: [
      {
        text: "Date",
        color: "#aaaaab",
        bold: true,
        width: "*",
        fontSize: 12,
        alignment: "right"
      }, {
        text: date,
        bold: true,
        color: "#333333",
        fontSize: 12,
        alignment: "right",
        width: 100
      }
    ]
  } ;
  stack.push(dateIssued);
  headerContent.push(stack);
  
return headerContent;

}

function getFromTo() {
let fromTo = [
    {
    columns: [
      {
        text: 'From',
        color: '#aaaaab',
        bold: true,
        fontSize: 14,
        alignment: 'left',
        margin: [0, 20, 0, 5],
      },
      {
        text: 'To',
        color: '#aaaaab',
        bold: true,
        fontSize: 14,
        alignment: 'left',
        margin: [0, 20, 0, 5],
      },
    ],
  },
  {
    columns: [
      {
        text: 'Your Name \n Your Company Inc.',
        bold: true,
        color: '#333333',
        alignment: 'left',
      },
      {
        text: 'Client Name \n Client Company',
        bold: true,
        color: '#333333',
        alignment: 'left',
      },
    ],
  },
  {
    columns: [
      {
        text: 'Address',
        color: '#aaaaab',
        bold: true,
        margin: [0, 7, 0, 3],
      },
      {
        text: 'Address',
        color: '#aaaaab',
        bold: true,
        margin: [0, 7, 0, 3],
      },
    ],
  },
  {
    columns: [
      {
        text: '9999 Street name 1A \n New-York City NY 00000 \n   USA',
        style: 'invoiceBillingAddress',
      },
      {
        text: '1111 Other street 25 \n New-York City NY 00000 \n   USA',
        style: 'invoiceBillingAddress',
      },
    ],
  }];

  return fromTo;
}

function getItemTable(){

    let layout = 
    {
        layout: {
          defaultBorder: false,
          hLineWidth: function(i, node) {
            return 1;
          },
          vLineWidth: function(i, node) {
            return 1;
          },
          hLineColor: function(i, node) {
            if (i === 1 || i === 0) {
              return '#bfdde8';
            }
            return '#eaeaea';
          },
          vLineColor: function(i, node) {
            return '#eaeaea';
          },
          hLineStyle: function(i, node) {
            // if (i === 0 || i === node.table.body.length) {
            return null;
            //}
          },
          // vLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
          paddingLeft: function(i, node) {
            return 10;
          },
          paddingRight: function(i, node) {
            return 10;
          },
          paddingTop: function(i, node) {
            return 2;
          },
          paddingBottom: function(i, node) {
            return 2;
          },
          fillColor: function(rowIndex, node, columnIndex) {
            return '#fff';
          },
        },
        table: {
          headerRows: 1,
          widths: ['*', 80],
          body: [
            [
              {
                text: 'ITEM DESCRIPTION',
                fillColor: '#eaf2f5',
                border: [false, true, false, true],
                margin: [0, 5, 0, 5],
                textTransform: 'uppercase',
              },
              {
                text: 'ITEM TOTAL',
                border: [false, true, false, true],
                alignment: 'right',
                fillColor: '#eaf2f5',
                margin: [0, 5, 0, 5],
                textTransform: 'uppercase',
              },
            ],
            [
              {
                text: 'Item 1',
                border: [false, false, false, true],
                margin: [0, 5, 0, 5],
                alignment: 'left',
              },
              {
                border: [false, false, false, true],
                text: '$999.99',
                fillColor: '#f5f5f5',
                alignment: 'right',
                margin: [0, 5, 0, 5],
              },
            ],
            [
              {
                text: 'Item 2',
                border: [false, false, false, true],
                margin: [0, 5, 0, 5],
                alignment: 'left',
              },
              {
                text: '$999.99',
                border: [false, false, false, true],
                fillColor: '#f5f5f5',
                alignment: 'right',
                margin: [0, 5, 0, 5],
              },
            ],
          ],
        },
      }

    return layout;
}

function getTotal(){
    let total = {
        layout: {
          defaultBorder: false,
          hLineWidth: function(i, node) {
            return 1;
          },
          vLineWidth: function(i, node) {
            return 1;
          },
          hLineColor: function(i, node) {
            return '#eaeaea';
          },
          vLineColor: function(i, node) {
            return '#eaeaea';
          },
          hLineStyle: function(i, node) {
            // if (i === 0 || i === node.table.body.length) {
            return null;
            //}
          },
          // vLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
          paddingLeft: function(i, node) {
            return 10;
          },
          paddingRight: function(i, node) {
            return 10;
          },
          paddingTop: function(i, node) {
            return 3;
          },
          paddingBottom: function(i, node) {
            return 3;
          },
          fillColor: function(rowIndex, node, columnIndex) {
            return '#fff';
          },
        },
        table: {
          headerRows: 1,
          widths: ['*', 'auto'],
          body: [
            [
              {
                text: 'Payment Subtotal',
                border: [false, true, false, true],
                alignment: 'right',
                margin: [0, 5, 0, 5],
              },
              {
                border: [false, true, false, true],
                text: '$999.99',
                alignment: 'right',
                fillColor: '#f5f5f5',
                margin: [0, 5, 0, 5],
              },
            ],
            [
              {
                text: 'Payment Processing Fee',
                border: [false, false, false, true],
                alignment: 'right',
                margin: [0, 5, 0, 5],
              },
              {
                text: '$999.99',
                border: [false, false, false, true],
                fillColor: '#f5f5f5',
                alignment: 'right',
                margin: [0, 5, 0, 5],
              },
            ],
            [
              {
                text: 'Total Amount',
                bold: true,
                fontSize: 20,
                alignment: 'right',
                border: [false, false, false, true],
                margin: [0, 5, 0, 5],
              },
              {
                text: 'USD $999.99',
                bold: true,
                fontSize: 20,
                alignment: 'right',
                border: [false, false, false, true],
                fillColor: '#f5f5f5',
                margin: [0, 5, 0, 5],
              },
            ],
          ],
        },
      };
      return total;
}

function getNotes(){
    let notes = [
        {
            text: 'NOTES',
            style: 'notesTitle',
          },
          {
            text: 'Some notes goes here \n Notes second line',
            style: 'notesText',
          }
    ];
    return notes;     
}

function downloadSummaryReport() {
  let content = [];

  let header = getOrderHeader("PURCHASE ORDER", "00001", "June 01, 2016");
  let fromTo = getFromTo();
  let newLine = {
    alignment: 'justify',
    margin: [40, 0],
    fontSize: 9,
    text: '\n\n'
    };

    let itemsHeader = {
    width: '100%',
    alignment: 'center',
    text: 'Invoice No. 123',
    bold: true,
    margin: [0, 10, 0, 10],
    fontSize: 15,
  };

  content.push(header);
  content.push(fromTo);
  content.push(newLine);
  content.push(itemsHeader);

  let itemsTable = getItemTable();
  content.push(itemsTable);
  content.push({text: '\n\n'});
  content.push({text: '\n'});

  let itemTotal =  getTotal();
  content.push(itemTotal);

  let notes = getNotes();
  content.push(notes);

  let tableLayouts = {
    hLayout: {
      hLineWidth: function (i, node) {
        if (i === 0 || i === node.table.body.length) {
          return 0;
        }
        return i === node.table.headerRows
          ? 2
          : 0;
      },
      vLineWidth: function (i) {
        return 0;
      },
      hLineColor: function (i) {
        return i === 1
          ? "black"
          : "#aaa";
      },
      paddingLeft: function (i) {
        return i === 0
          ? 0
          : 2;
      },
      paddingRight: function (i, node) {
        return i === node.table.widths.length - 1
          ? 0
          : 2;
      }
    }
  };

  var fonts = {
    CourierPrime: {
      normal: "CourierPrime.ttf",
      bold: "CourierPrimeBold.ttf",
      italics: "CourierPrimeItalic.ttf",
      bolditalics: "CourierPrimeBoldItalic.ttf"
    },
    Roboto: {
      normal: "Roboto-Regular.ttf",
      bold: "Roboto-Medium.ttf",
      italics: "Roboto-Italic.ttf",
      bolditalics: "Roboto-MediumItalic.ttf"
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
        color: "black"
      },
      tableHeaderObst: {
        bold: false,
        fontSize: 7.5,
        color: "black"
      },
      tableData: {
        bold: false,
        fontSize: 9,
        color: "black"
      },
      tableDataBold: {
        bold: false,
        fontSize: 7.5,
        color: "black"
      },
      tableDef: {
        bold: false,
        fontSize: 9,
        margin: [
          10, 1
        ],
        color: "black"
      },
      notesTitle: {
        fontSize: 10,
        bold: true,
        margin: [0, 50, 0, 3]
      },
      notesText: {
        fontSize: 10
      },
      defaultStyle: {
        columnGap: 20
        //font: 'Quicksand',
      }
    }
  };

  var callbackFunction = function () {
    // Here implement function for hide waiting loader
  };
  // let airnavtableforpdf = table(airnavtabledata, ['anv', 'value']);
  let dfname = `Summary` + ".pdf"; //'SearchResult-' + new Date(Date.now()).toLocaleString().split(',')[0].split("/").join("-") + '.pdf';

  // pdfMake.createPdf(dd, null, fonts).download(dfname, callbackFunction);
  pdfMake.createPdf(dd, tableLayouts, fonts).download(dfname, callbackFunction);
}

