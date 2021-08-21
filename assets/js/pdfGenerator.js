function getOrderHeader(orderType, orderNumber, date) {
  let headerContent = [];
  let header = {
    columns: [
      {
        image: companyImage,
        width: 75,
        height: 50
      },
      {
        columns: [
          {
            text: orderType,
            color: "#333333",
            width: "*",
            fontSize: 20,
            bold: true,
            alignment: "right",
            margin: [0, 0, 0, 15]
          },
          {text: "\n\n"}
        ],
        width: 880
      },
      
    ]
  };
  headerContent.push(header);
  let stack = [];
  let orderNo = {
    columns: [
      {
        text: "Order No",
        color: "#aaaaab",
        bold: true,
        width: "*",
        fontSize: 11,
        alignment: "right"
      }, {
        text: orderNumber,
        bold: true,
        color: "#333333",
        fontSize: 11,
        alignment: "right",
        width: 100
      }
    ]
  };

  stack.push(orderNo);

  let dateIssued = {
    columns: [
      {
        text: "Date",
        color: "#aaaaab",
        bold: true,
        width: "*",
        fontSize: 11,
        alignment: "right"
      }, {
        text: date,
        bold: true,
        color: "#333333",
        fontSize: 11,
        alignment: "right",
        width: 100
      }
    ]
  };
  stack.push(dateIssued);
  headerContent.push(stack);

  return headerContent;
}

function getFromToPO(fromCompany, toCompany, fromAddres, toAddress) {
  let fromTo = [
    {
      columns: [
        {
          text: "Bill & Ship To",
          color: "#aaaaab",
          bold: true,
          fontSize: 11,
          alignment: "left",
          margin: [0, 20, 0, 5]
        }, {
          text: "Supplier",
          color: "#aaaaab",
          bold: true,
          fontSize: 11,
          alignment: "left",
          margin: [0, 20, 0, 5]
        }
      ]
    }, {
      columns: [
        {
          text: toCompany,
          bold: true,
          color: "#333333",
          fontSize: 11,
          alignment: "left"
        }, {
          text: fromCompany,
          bold: true,
          color: "#333333",
          fontSize: 11,
          alignment: "left"
        }
      ]
    }, {
      columns: [
        {
          text: toAddress,
          fontSize: 11,
          style: "invoiceBillingAddress"
        }, {
          text: fromAddres,
          fontSize: 11,
          style: "invoiceBillingAddress"
        }
      ]
    }, {
      columns: [
        {
          text: "Namal Gamage",
          fontSize: 11,
          margin: [
            0, 4, 0, 4
          ],
          style: "invoiceBillingAddress"
        }, {
          text: "J.C.P Perera",
          fontSize: 11,
          margin: [
            0, 4, 0, 4
          ],
          style: "invoiceBillingAddress"
        }
      ]
    }, {
      columns: [
        {
          text: "0712384000",
          fontSize: 11,
          style: "invoiceBillingAddress"
        }, {
          text: "0712384000",
          fontSize: 11,
          style: "invoiceBillingAddress"
        }
      ]
    }
  ];

  return fromTo;
}

function getItemTable(items) {

  let layout = {
    layout: {
      defaultBorder: false,
      hLineWidth: function (i, node) {
        return 1;
      },
      vLineWidth: function (i, node) {
        return 1;
      },
      hLineColor: function (i, node) {
        if (i === 1 || i === 0) {
          return "#bfdde8";
        }
        return "#eaeaea";
      },
      vLineColor: function (i, node) {
        return "#eaeaea";
      },
      hLineStyle: function (i, node) {
        // if (i === 0 || i === node.table.body.length) {
        return null;
        //}
      },
      // vLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
      paddingLeft: function (i, node) {
        return 10;
      },
      paddingRight: function (i, node) {
        return 10;
      },
      paddingTop: function (i, node) {
        return 2;
      },
      paddingBottom: function (i, node) {
        return 2;
      },
      fillColor: function (rowIndex, node, columnIndex) {
        return "#fff";
      }
    },
    table: {
      headerRows: 1,
      widths: [
        20, "*", 80, 80, 80
      ],
      body: getItemsDetails(items)
    }
  };

  return layout;
}

function getItemsDetails(){
  let tableHeader = [];
  let firstRow = [
    {
      text: "No",
      fillColor: "#eaf2f5",
      border: [
        false, true, false, true
      ],
      fontSize: 11
    }, {
      text: "Item",
      fillColor: "#eaf2f5",
      border: [
        false, true, false, true
      ],
      fontSize: 11
    }, {
      text: "Qty",
      fillColor: "#eaf2f5",
      border: [
        false, true, false, true
      ],
      fontSize: 11
    }, {
      text: "Unit Price(Rs)",
      fillColor: "#eaf2f5",
      border: [
        false, true, false, true
      ],
      fontSize: 11
    }, {
      text: "Item Total(Rs)",
      border: [
        false, true, false, true
      ],
      alignment: "right",
      fontSize: 11,
      fillColor: "#eaf2f5"
    }
  ];
  tableHeader.push(firstRow);

  for (let i = 0; i <= 10; i++) {
    let item = [
      {
        text: "2",
        style: "itemDetails"
      }, {
        text: "Item 2",
        style: "itemDetails"
      }, {
        text: "2",
        style: "itemDetails"
      }, {
        text: "100.00",
        style: "itemDetails"
      }, {
        text: "200.00",
        style: "itemPrice"
      }
    ];
    tableHeader.push(item);
  };
  return tableHeader;
}

function getTotal(subtotal, discount, totalPrice) {
  let total = {
    layout: {
      defaultBorder: false,
      hLineWidth: function (i, node) {
        return 1;
      },
      vLineWidth: function (i, node) {
        return 1;
      },
      hLineColor: function (i, node) {
        return "#eaeaea";
      },
      vLineColor: function (i, node) {
        return "#eaeaea";
      },
      hLineStyle: function (i, node) {
        // if (i === 0 || i === node.table.body.length) {
        return null;
        //}
      },
      // vLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
      paddingLeft: function (i, node) {
        return 10;
      },
      paddingRight: function (i, node) {
        return 10;
      },
      paddingTop: function (i, node) {
        return 3;
      },
      paddingBottom: function (i, node) {
        return 3;
      },
      fillColor: function (rowIndex, node, columnIndex) {
        return "#fff";
      }
    },
    table: {
      headerRows: 1,
      widths: [
        "*", "auto"
      ],
      body: [
        [
          {
            text: "Payment Subtotal",
            border: [
              false, true, false, true
            ],
            alignment: "right",
            margin: [0, 2, 0, 2]
          }, {
            border: [
              false, true, false, true
            ],
            text: subtotal,
            alignment: "right",
            fillColor: "#f5f5f5",
            margin: [0, 2, 0, 2]
          }
        ],
        [
          {
            text: "Discount",
            border: [
              false, false, false, true
            ],
            alignment: "right",
            margin: [0, 2, 0, 2]
          }, {
            text: discount,
            border: [
              false, false, false, true
            ],
            fillColor: "#f5f5f5",
            alignment: "right",
            margin: [0, 2, 0, 2]
          }
        ],
        [
          {
            text: "Total Amount",
            bold: true,
            fontSize: 14,
            alignment: "right",
            border: [
              false, false, false, true
            ],
            margin: [0, 2, 0, 2]
          }, {
            text: totalPrice,
            bold: true,
            fontSize: 14,
            alignment: "right",
            border: [
              false, false, false, true
            ],
            fillColor: "#f5f5f5",
            margin: [0, 2, 0, 2]
          }
        ]
      ]
    }
  };
  return total;
}

function getNotes(note) {
  let notes = [
    {
      text: "NOTES",
      style: "notesTitle"
    }, {
      text: note,
      style: "notesText"
    }
  ];
  return notes;
}

function createPurchaseOrder(){
  let content = [];

  let header = getOrderHeader("PURCHASE ORDER", "00001", "June 01, 2016");
  let fromTo = getFromToPO("ABC Pvt Ltd", "Anthony Distributors", "No:12, 1 st Lane, Badulla", "No84/21, Nawala");
  let newLine = {
    alignment: "justify",
    margin: [
      40, 0
    ],
    fontSize: 9,
    text: "\n\n"
  };

  let itemsHeader = {
    width: "100%",
    alignment: "center",
    text: "Item Details",
    bold: true,
    margin: [
      0, 5, 0, 5
    ],
    fontSize: 11
  };

  content.push(header);
  content.push(fromTo);
  content.push(newLine);
  content.push(itemsHeader);

  let itemsTable = getItemTable(items);
  content.push(itemsTable);
  content.push({text: "\n\n"});
  content.push({text: "\n"});

  let itemTotal = getTotal("100.00", "0%", "Rs. 100.00");
  content.push(itemTotal);

  let notes = getNotes("Some notes goes here \n Notes second line");
  content.push(notes);
  content.push([
    {
      text: "Authorized By : ..............................",
      fontSize: 12,
      alignment: "left",
      margin: [0, 30, 0, 15]
    }
  ]);
  return content;

};


function createSalesOrder(){
  let content = [];

  let header = getOrderHeader("SALES ORDER", "00002", "June 01, 2016");
  let fromTo = getFromToPO("ABC Pvt Ltd", "Anthony Distributors", "No:12, 1 st Lane, Badulla", "No84/21, Nawala");
  let newLine = {
    alignment: "justify",
    margin: [
      40, 0
    ],
    fontSize: 9,
    text: "\n\n"
  };

  let itemsHeader = {
    width: "100%",
    alignment: "center",
    text: "Item Details",
    bold: true,
    margin: [
      0, 5, 0, 5
    ],
    fontSize: 11
  };

  content.push(header);
  content.push(fromTo);
  content.push(newLine);
  content.push(itemsHeader);

  let itemsTable = getItemTable(items);
  content.push(itemsTable);
  content.push({text: "\n\n"});
  content.push({text: "\n"});

  let itemTotal = getTotal("100.00", "0%", "Rs. 100.00");
  content.push(itemTotal);

  let notes = getNotes("Some notes goes here \n Notes second line");
  content.push(notes);
  content.push([
    {
      text: "Authorized By : ..............................",
      fontSize: 12,
      alignment: "left",
      margin: [0, 30, 0, 15]
    }
  ]);
  return content;
}


function downloadpdf(con) {
  let content = con;

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
      itemDetails: {
        fontSize: 11,
        border: [
          false, false, false, true
        ],
        margin: [
          0, 2, 0, 2
        ],
        alignment: "left"
      },
      itemPrice: {
        border: [
          false, false, false, true
        ],
        fillColor: "#f5f5f5",
        alignment: "right",
        fontSize: 11
      },
      defaultStyle: {
        columnGap: 14
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
