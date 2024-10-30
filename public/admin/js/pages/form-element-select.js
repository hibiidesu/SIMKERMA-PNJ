// let choices = document.querySelectorAll('.choices');
// let initChoice;
// for(let i=0; i<choices.length;i++) {
//   if (choices[i].classList.contains("multiple-remove")) {
//     initChoice = new Choices(choices[i],
//       {
//         delimiter: ',',
//         editItems: true,
//         maxItemCount: -1,
//         removeItemButton: true,
//       });
//   }else{
//     initChoice = new Choices(choices[i]);
//   }
// }

new Choices(".choices", {
    removeItemButton: true,
});
new Choices(".choices-2", {
    removeItemButton: true,
});
new Choices(".choices-3", {
    removeItemButton: true,
});
new Choices(".choices-4", {
    removeItemButton: true,
});
