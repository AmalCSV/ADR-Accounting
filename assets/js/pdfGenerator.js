function getOrderHeader(orderType, orderNumber, date, companyImage) {
  let headerContent = [];
  let header = {
    columns: [
      {
        image: companyImage,
        width: 75,
        height: 50
      }, {
        columns: [
          {
            text: orderType,
            color: "#333333",
            width: "*",
            fontSize: 20,
            bold: true,
            alignment: "right",
            margin: [0, 0, 0, 15]
          }, {
            text: "\n\n"
          }
        ],
        width: 880
      }
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

function getFromToPO(orderPdf) {
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
          text: "Vendor",
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
          text: orderPdf.toCompany,
          bold: true,
          color: "#333333",
          fontSize: 11,
          alignment: "left",
          margin: [0, 0, 0, 5]
        }, {
          text: orderPdf.fromCompany,
          bold: true,
          color: "#333333",
          fontSize: 11,
          alignment: "left",
          margin: [0, 0, 0, 5]
        }
      ]
    }, {
      columns: [
        {
          text: orderPdf.toAddress,
          fontSize: 11,
          style: "invoiceBillingAddress"
        }, {
          text: orderPdf.fromAddress,
          fontSize: 11,
          style: "invoiceBillingAddress"
        }
      ]
    }, {
      columns: [
        {
          text: orderPdf.toContactPerson,
          fontSize: 11,
          margin: [
            0, 4, 0, 4
          ],
          style: "invoiceBillingAddress"
        }, {
          text:  orderPdf.fromContactPerson,
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
          text: orderPdf.toMobile,
          fontSize: 11,
          style: "invoiceBillingAddress"
        }, {
          text: orderPdf.fromMobile,
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

function getItemsDetails(items) {
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

  if (items && items.length > 0) {
    for (let i = 0; i < items.length; i++) {
      let itemContent = [
        {
          text: items[i].itemNumber,
          style: "itemDetails"
        }, {
          text: items[i].itemName,
          style: "itemDetails"
        }, {
          text: items[i].quantity,
          style: "itemDetails"
        }, {
          text: items[i].unitPrice,
          style: "itemDetails"
        }, {
          text: items[i].totalPrice,
          style: "itemPrice"
        }
      ];
      tableHeader.push(itemContent);
    }
  }
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
            text: discount ? "Discount" : '\n',
            border: [
              false, false, false, true
            ],
            alignment: "right",
            margin: [0, 2, 0, 2]
          }, {
            text: discount ? discount : '\n',
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

function downloadOrderPdf(orderType, order, items, secondParty) {
  let content = [];
  let type = "";

  let company = getCompanyDetails();

  let orderPdf = {
    fromCompany : "",
    fromAddress : "",
    toCompany: "",
    toAddress : ""
  }
  if (orderType === "PO") {
    type = "PURCHASE ORDER";
    orderPdf = {
      fromCompany : secondParty.companyName,
      fromAddress : secondParty.address + ", " + (secondParty.address2 != "" ? secondParty.address2  + ", " : "") + secondParty.city,
      fromContactPerson :  secondParty.contactPerson,
      fromMobile : secondParty.mobile,
      toCompany: company.companyName,
      toAddress : company.address + ", " + (company.address2 != "" ? (company.address2  + ", ") : "") + company.city,
      toContactPerson : company.fullName,
      toMobile : company.mobile,
    }

  } else {
    type = "SALES ORDER";
  }

  let header = getOrderHeader(type, order.orderNumber, order.orderDate, company.logo);
  let fromTo = getFromToPO(orderPdf);
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

  let itemTotal = getTotal(order.amount, order.discount, "Rs. " + order.amount);
  content.push(itemTotal);

  let notes = getNotes(order.description);
  content.push(notes);
  content.push([
    {
      text: "Authorized By : ..............................",
      fontSize: 12,
      alignment: "left",
      margin: [0, 30, 0, 15]
    }
  ]);
  content.push({text: "\n"});

  if (orderType === "SO") {
    content.push({text: "Payments\n\n"});
    content.push(paymentSection());
  }
  downloadpdf(content, order.orderNumber);
}

function downloadpdf(con, docName) {
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
        fontSize: 10,
        margin: [0, 10, 0, 50]
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
  let dfname = docName + ".pdf"; //'SearchResult-' + new Date(Date.now()).toLocaleString().split(',')[0].split("/").join("-") + '.pdf';

  // pdfMake.createPdf(dd, null, fonts).download(dfname, callbackFunction);
  pdfMake.createPdf(dd, tableLayouts, fonts).download(dfname, callbackFunction);
}

function paymentSection() {
  return {
    style: "tableExample",
    layout: {
      hLineWidth: function (i, node) {
        return 1;
      },
      vLineWidth: function (i, node) {
        return 1;
      },
      hLineColor: function (i, node) {
        return "gray";
      },
      vLineColor: function (i, node) {
        return "gray";
      }
    },
    table: {
      headerRows: 1,
      widths: [
        80, 90, "*", 90, 80
      ],
      heights: 80,
      body: [
        [
          "Date", "Amount", "Type (Cash or cheque)", "Cheque No", "Cheque Date"
        ],
        [
          " ", " ", "", "", ""
        ],
        [
          " ", " ", "", "", ""
        ],
        [
          " ", " ", "", "", ""
        ],
        [
          " ", " ", "", "", ""
        ]
      ]
    }
  };
}
