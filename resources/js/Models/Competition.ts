export default interface Competition {
    name: string;
    id: string;
    must_be_unique: boolean;
    description: string;
    date_start: string;
    date_end: string;
}