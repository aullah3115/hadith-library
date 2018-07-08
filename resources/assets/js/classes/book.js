export default class Book
{
  constructor(book){
    this.id = book.id;
    this.name = book.name;
    this.author_id = book.author_id;
  }

  storeSections(sections){
    this.sections = sections;
  }

  addSection(section){
    this.sections.push(section);
  }
}
