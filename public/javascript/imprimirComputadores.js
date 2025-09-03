function imprimirComputadores() {
  const printContent = document.getElementById("printable-area").innerHTML;

  const printWindow = window.open('', '_blank');
  printWindow.document.write('<html><head><title>Imprimir Computadores</title>');
  printWindow.document.write('<style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; font-size: 12px; }</style>');
  printWindow.document.write('</head><body>');
  printWindow.document.write(printContent);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}