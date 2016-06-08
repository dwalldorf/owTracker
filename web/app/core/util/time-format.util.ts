export class TimeFormatUtil {

    public static toDateTimeString(time: number): string {
        var date = new Date(time * 1000);
        return date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + ': ' + date.getHours() + ':' + date.getMinutes();
    }

}